<?php

/**
 * Records changes made to an object during save operations.
 */
class AuditableBehavior extends ModelBehavior {
  /**
   * A copy of the object as it existed prior to the save. We're going
   * to store this off so we can calculate the deltas after save.
   *
   * @var   Object
   * @access  private
   */
  private $_original = null;

  /**
   * Initiate behavior for the model using specified settings.
   *
   * Available settings:
   *   - ignore array, optional
   *            An array of property names to be ignored when records
   *            are created in the deltas table.
   *   - habtm  array, optional
   *            An array of models that have a HABTM relationship with
   *            the acting model and whose changes should be monitored
   *            with the model.
   *
   * @param   object  $Model      Model using the behavior
   * @param   array   $settings   Settings overrides.
   */
  public function setup( $Model, $settings = array() ) {
    if( !isset( $this->settings[$Model->alias] ) ) {
      $this->settings[$Model->alias] = array(
        'ignore' => array( 'created', 'updated', 'modified' ),
        'habtm'  => count( $Model->hasAndBelongsToMany ) > 0
          ? array_keys( $Model->hasAndBelongsToMany )
          : array()
      );
    }
    if( !is_array( $settings ) ) {
      $settings = array();
    }
    $this->settings[$Model->alias] = array_merge_recursive( $this->settings[$Model->alias], $settings );

    /**
     * Ensure that no HABTM models which are already auditable
     * snuck into the settings array. That would be bad. Same for
     * any model which isn't a HABTM association.
     */
    foreach( $this->settings[$Model->alias]['habtm'] as $index => $Model_name ) {
      /**
       * Note the "===" in the condition. The type check is important,
       * so don't change it just because it may look like a mistake.
       */
      if( !array_key_exists( $Model_name, $Model->hasAndBelongsToMany ) || array_search( 'Auditable', $Model->$Model_name->actsAs ) === true ) {
        unset( $this->settings[$Model->alias]['habtm'][$index] );
      }
    }
  }

  /**
   * Executed before a save() operation.
   *
   * @return  boolean
   * @access  public
   */
  public function beforeSave( $Model ) {
    # If we're editing an existing object, save off a copy of
    # the object as it exists before any changes.
    if( !empty( $Model->id ) ) {
      $this->_original = $this->_getModelData( $Model );
    }
    
    return true;
  }
  
  /**
   * Executed before a delete() operation.
   *
   * @param 	$Model
   * @return	boolean
   * @access	public
   */
  public function beforeDelete( $Model, $cascade = true ) {
    $this->_original = $Model->find(
      'first',
      array(
        'contain'    => false,
        'conditions' => array( $Model->alias . '.' . $Model->primaryKey => $Model->id ),
      )
    );
    
    return true;
  }

  /**
   * function afterSave
   * Executed after a save operation completes.
   *
   * @param   $created  Boolean. True if the save operation was an
   *                    insertion. False otherwise.
   * @return  void
   */
  public function afterSave( $Model, $created ) {
    $audit = $this->_getModelData( $Model );
    $audit[$Model->alias][$Model->primaryKey] = $Model->id;

    /**
     * Create a runtime association with the Audit model and bind the
     * Audit model to its AuditDelta model.
     */
    $Model->bindModel(
      array( 'hasMany' => array( 'Audit' ) )
    );
    $Model->Audit->bindModel(
      array( 'hasMany' => array( 'AuditDelta' ) )
    );
    
    /**
     * If a current_user() method exists in the model class (or, of
     * course, in a superclass) the call that method to pull all user
     * data. Assume than an id field exists.
     */
    $source = array();
    if( method_exists( $Model, 'current_user' ) ) {
      $source = $Model->current_user();
    }
    
    $data = array(
      'Audit' => array(
        'event'     => $created ? 'CREATE' : 'EDIT',
        'model'     => $Model->alias,
        'entity_id' => $Model->id,
        'json_object' => json_encode( $audit ),
        'source_id' => isset( $source['id'] ) ? $source['id'] : null
      )
    );

    /**
     * We have the audit_logs record, so let's collect the set of
     * records that we'll insert into the audit_log_deltas table.
     */
    $updates = array();
    foreach( $audit[$Model->alias] as $property => $value ) {
      $delta = array();

      /**
       * Ignore virtual fields (Cake 1.3+) and specified properties
       */
      if( ( method_exists( $Model, 'isVirtualField' ) && $Model->isVirtualField( $property ) ) || in_array( $property, $this->settings[$Model->alias]['ignore'] )  ) {
        continue;
      }

      if( !$created ) {
        if( array_key_exists( $property, $this->_original[$Model->alias] ) && $this->_original[$Model->alias][$property] != $value ) {
          /**
           * If the property exists in the original _and_ the
           * value is different, store it.
           */
          $delta = array(
            'AuditDelta' => array(
              'property_name' => $property,
              'old_value'     => $this->_original[$Model->alias][$property],
              'new_value'     => $value
            )
          );
          array_push( $updates, $delta );
        }
      }
    }

    # Insert an audit record if a new model record is being created
    # or if something we care about actually changed.
    if( $created || count( $updates ) ) {
      $Model->Audit->create();
      $Model->Audit->save( $data );

      if( $created ) {
        if( method_exists( $Model, 'afterAuditCreate' ) ) {
          $Model->afterAuditCreate( $Model );
        }
      }
      else {
        if( method_exists( $Model, 'afterAuditUpdate' ) ) {
          $Model->afterAuditUpdate( $Model, $this->_original, $updates, $Model->Audit->id );
        }
      }
    }
    
    # Insert a delta record if something changed.
    if( count( $updates ) ) {
      foreach( $updates as $delta ) {
        $delta['AuditDelta']['audit_id'] = $Model->Audit->id;

        $Model->Audit->AuditDelta->create();
        $Model->Audit->AuditDelta->save( $delta );

        if( !$created && method_exists( $Model, 'afterAuditProperty') ) {
          $Model->afterAuditProperty(
            $Model,
            $delta['AuditDelta']['property_name'],
            $this->_original[$Model->alias][$delta['AuditDelta']['property_name']],
            $delta['AuditDelta']['new_value']
          );
        }
      }
    }

    /**
     * Destroy the runtime association with the Audit
     */
    $Model->unbindModel(
      array( 'hasMany' => array( 'Audit' ) )
    );

    /**
     * Unset the original object value so it's ready for the next
     * call.
     */
    if( isset( $this->_original ) ) {
      $this->_original = null;
    }
    return true;    
  }
  
  /**
   * Executed after a model is deleted.
   *
   * @param 	$Model
   * @return	void
   * @access	public
   */
  public function afterDelete( $Model ) {
    /**
     * If a current_user() method exists in the model class (or, of
     * course, in a superclass) the call that method to pull all user
     * data. Assume than an id field exists.
     */
    $source = array();
    if( method_exists( $Model, 'current_user' ) ) {
      $source = $Model->current_user();
    }
    
    $audit = $this->_original;
    $data  = array(
      'Audit' => array(
        'event'       => 'DELETE',
        'model'       => $Model->alias,
        'entity_id'   => $Model->id,
        'json_object' => json_encode( $audit ),
        'source_id'   => isset( $source['id'] ) ? $source['id'] : null
      )
    );
    
    $this->Audit = ClassRegistry::init( 'Audit' );
    $this->Audit->save( $data );
  }

  /**
   * function _getModelData
   * Retrieves the entire set model data contained to the primary
   * object and any/all HABTM associated data that has been configured
   * with the behavior.
   *
   * Additionally, for the HABTM data, all we care about is the IDs,
   * so the data will be reduced to an indexed array of those IDs.
   *
   * @param   $Model
   * @return  array
   */
  private function _getModelData( $Model ) {
    /**
     * Retrieve the model data along with its appropriate HABTM
     * model data.
     */
    $data = $Model->find(
      'first',
      array(
        'contain' => !empty( $this->settings[$Model->alias]['habtm']  )
          ? array_values( $this->settings[$Model->alias]['habtm'] )
          : array(),
        'conditions' => array( $Model->alias . '.' . $Model->primaryKey => $Model->id )
      )
    );

    $audit_data = array(
      $Model->alias => $data[$Model->alias]
    );

    foreach( $this->settings[$Model->alias]['habtm'] as $habtm_model ) {
      if( array_key_exists( $habtm_model, $Model->hasAndBelongsToMany ) && isset( $data[$habtm_model] ) ) {
        $habtm_ids = Set::combine(
          $data[$habtm_model],
          '{n}.id',
          '{n}.id'
        );
        /**
         * Grab just the id values and sort those
         */
        $habtm_ids = array_values( $habtm_ids );
        sort( $habtm_ids );

        $audit_data[$Model->alias][$habtm_model] = implode( ',', $habtm_ids );
      }
    }

    return $audit_data;
  }
}

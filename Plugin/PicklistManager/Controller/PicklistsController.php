<?php
/**
 * Copyright 2012, Zubin Khavarian (http://zubink.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2012, Zubin Khavarian (http://zubink.com)
 * @link http://zubink.com
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('AppController', 'Controller');

/**
 * Picklist controller to manage creation and manipulation of picklists and picklist options
 *
 * @package Plugin.PicklistManager
 * @subpackage Plugin.PicklistManager.Controller
 * @author Zubin Khavarian
 */
class PicklistsController extends PicklistManagerAppController
{

    /**
     * @var array
     * @access public
     */
    //public $helpers = array();

    /**
     * @var array
     * @access public
     */
    public $uses = array('PicklistManager.Picklist', 'PicklistManager.PicklistOption');
    //public $uses = array('PicklistOption');

    
    /**
     * @access public
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
    }


    /**
     * Action to provide an index list of all picklists
     *
     * @access public
     */
    public function admin_index()
    {
        $picklists = $this->Picklist->fetchAllPicklists();
        $this->set('picklists', $picklists);
        $this->set('title_for_layout', 'Picklist - Index');
    }


    /**
     * Action to create a new picklist and save it
     *
     * @access public
     */
    public function admin_create()
    {
        if(!empty($this->data)) {

            $opStatus = $this->Picklist->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Picklist saved successfully', 'success');
            } else {
                $this->Session->setFlash('There was a problem saving the picklist', 'error');
            }

            $this->redirect('/admin/picklist_manager/picklists/index');

        }
        
        $this->set('title_for_layout', 'Create a Picklist');

    }

    
    /**
     * Action for opening an existing picklist for edit and saving the changes
     * 
     * @access public
     * @param string $picklistId
     */
    public function admin_edit($picklistId)
    {
        if(!empty($this->data)) {
            $opStatus = $this->Picklist->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Picklist updated successfully', 'success');
            } else {
                $this->Session->setFlash('There was a problem updating picklist', 'error');
            }

            $this->redirect('/admin/picklist_manager/picklists/index');

        } else {
            $picklist = $this->Picklist->fetchPicklist($picklistId);
            $this->data = $picklist;
            $this->set('picklist', $picklist);
            $this->set('title_for_layout', 'Picklist - Edit');
        }
    }


    /**
     * Action to view a picklist given its id
     *
     * @access public
     * @param string $picklistId
     */
    public function admin_view($picklistId)
    {
        $picklist = $this->Picklist->fetchPicklistWithOptions($picklistId);
        $this->set('picklist', $picklist);
        $this->set('title_for_layout', 'Picklist - Edit');
    }


    /**
     * Action to delete a picklist given its id
     * 
     * @access public
     * @param string $picklistId
     */
    public function admin_delete($picklistId)
    {
        $opStatus = $this->Picklist->deletePicklist($picklistId);

        if($opStatus) {
            $this->Session->setFlash('Picklist deleted successfully', 'success');
        } else {
            $this->Session->setFlash('There was a problem deleting the picklist', 'error');
        }

        $this->redirect('/admin/picklist_manager/picklists/index');
    }


    /**
     * Action to add a new picklist option to a given picklist
     *
     * @access public
     * @param string $picklistId
     */
    public function admin_add_option($picklistId)
    {
        if(!empty($this->data)) {
            $opStatus = $this->PicklistOption->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Picklist option saved successfully', 'success');
            } else {
                $this->Session->setFlash('There was a problem saving the picklist option', 'error');
            }

            $this->redirect('/admin/picklist_manager/picklists/view/' . $picklistId);
        }

        $this->set('picklist_id', $picklistId);

        $this->set('title_for_layout', 'Picklist Option - Add');
    }


    /**
     * Action to edit an existing picklist option given its id
     *
     * @access public
     * @param string $picklistOptionId
     */
    public function admin_edit_option($picklistOptionId)
    {
        if(!empty($this->data)) {
            $opStatus = $this->PicklistOption->save($this->data);

            if($opStatus) {
                $this->Session->setFlash('Picklist option updated successfully', 'success');
            } else {
                $this->Session->setFlash('There was a problem updating the picklist option', 'error');
            }

            $picklistOption = $this->PicklistOption->fetchPicklistOption($picklistOptionId);
            $picklistId = $picklistOption['PicklistOption']['picklist_id'];

            $this->redirect("/admin/picklist_manager/picklists/view/{$picklistId}");
        }

        $picklistOption = $this->PicklistOption->fetchPicklistOption($picklistOptionId);
        $this->data = $picklistOption;
        $this->set('picklist_option', $picklistOption);

        $this->set('picklist_option_id', $picklistOptionId);

        $this->set('title_for_layout', 'Picklist Option - Edit');
    }


    /**
     * Action to delete a picklist option given its id
     *
     * @access public
     * @param string $picklistOptionId The picklist option to delete
     */
    public function admin_delete_option($picklistOptionId)
    {
        $picklistOption = $this->PicklistOption->fetchPicklistOption($picklistOptionId);
        $picklistId = $picklistOption['PicklistOption']['picklist_id'];

        $opStatus = $this->PicklistOption->delete($picklistOptionId);

        if($opStatus) {
            $this->Session->setFlash('Picklist option deleted successfully', 'success');


        } else {
            $this->Session->setFlash('There was a problem deleting the picklist option', 'error');
        }

        $this->redirect('/admin/picklist_manager/picklists/view/' . $picklistId);
    }


    /**
     * Action to test how picklist options will be generated as an HTML select drop-down element
     * 
     * @access public
     * @param string $picklistId The picklist id for which to display the test
     */
    public function admin_test($picklistId)
    {
        //$alias = $this->Picklist->getPicklistAlias($picklistId);
        $picklist = $this->Picklist->fetchPicklist($picklistId);
        $alias = $picklist['Picklist']['alias'];

        $picklistGrouped = $this->Picklist->fetchPicklistOptions($alias, array(
            //'categoryFilter' => 'user_group',
            'grouped' => true,
            //'emptyOption' => false,
            //'otherOption' => false
        ));

        $picklistFlat = $this->Picklist->fetchPicklistOptions($alias, array(
            //'categoryFilter' => 'user_group',
            'grouped' => false,
            //'emptyOption' => false,
            //'otherOption' => false
        ));

        $this->set('title_for_layout', 'Picklist Option - Test');

        $this->set('picklist', $picklist);
        $this->set('picklist_grouped', $picklistGrouped);
        $this->set('picklist_flat', $picklistFlat);
    }
}

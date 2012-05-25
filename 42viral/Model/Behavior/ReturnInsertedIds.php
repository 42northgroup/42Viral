<?php
/**
 * Populates the insertedIds array instancieated in the AppModel with the ids of newly created rows of data
 * 
 * PHP 5.3
 * 
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @package 42viral
 */

/**
 * Populates the insertedIds array instancieated in the AppModel with the ids of newly created rows of data
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 * @package 42viral
 */
class ReturnInsertedIdsBehavior extends ModelBehavior
{
    /**
     * Name of the model
     *
     * @var String
     * @access public
     */
    public $name = 'ReturnInsertedIds';
        
    /**
     * Inserts the ID of the created instance into the insertedIds array
     * 
     * @access public
     * @param array $model
     * @param boolean $created 
     *
     */
    public function afterSave(&$model, $created) {
        array_push($model->insertedIds, $model->id);
    }
}
?>

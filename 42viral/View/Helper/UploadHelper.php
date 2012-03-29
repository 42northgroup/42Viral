<?php
/**
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
 */

App::uses('AppHelper', 'View/Helper');

/**
 * A helper for hiding unauthorized access.
 * 
 * @package app
 * @subpackage app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
class UploadHelper extends AppHelper
{

    public $helpers = array('Html');
        
    /**
     * Uses ACLs and sessions to determine if we should show a link
     * @param string $check
     * @param string $title
     * @param mixed $url
     * @param array $options
     * @param type $confirmMessage
     * @return string
     * @access public
     */
    public function img($upload, $size='128px') {
        
        //lets save the file with the UUID.
        $ext = pathinfo($upload['name'], PATHINFO_EXTENSION);
        $name = "{$upload['id']}.{$ext}";
        
        return $this->Html->link(
                    $this->Html->image($upload['path'] . $name, 
                            array(
                                'width'=>$size,
                                'style'=>'display:block',
                                'alt'=>$upload['name'],
                                'title'=>$upload['name']
                                )
                    ), 
                    //$upload['path'] . $name,
                    '/uploads/image/' . $upload['id'],
                    array(
                        'target'=>'blank', 
                        'escape'=>false
                    )         
                );

    }
 
}
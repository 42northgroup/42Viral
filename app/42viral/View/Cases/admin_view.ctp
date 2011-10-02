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

/**
 * @author Jason D Snider <jason.snider@42viral.org>
 */



    $additional  = array(
        array(
            'text'=>"Complete",
            'url'=>"/admin/cases/complete/{$case['CaseModel']['id']}",
            'options' => array(),
            'confirm'=>null
        ),            
        array(
            'text'=>"Edit",
            'url'=>"/admin/cases/edit/{$case['CaseModel']['id']}",
            'options' => array(),
            'confirm'=>null
        ),
        array(
            'text'=>"Delete",
            'url'=>"/admin/cases/delete/{$case['CaseModel']['id']}",
            'options' => array(),
            'confirm'=>'Are you sure you want to delete this? \n This action CANNOT be reversed!'
        ),
    );



    echo $this->element('Navigation' . DS . 'local', array('section'=>'cases', 'additional'=>$additional));

?>
<div><?php echo $case['CaseModel']['body']; ?></div>
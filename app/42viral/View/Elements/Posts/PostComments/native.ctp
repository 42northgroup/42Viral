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
 * UI for creating a web page
 * @author Jason D Snider <jason.snider@42viral.org>
 */

if($this->Session->read('Auth.User')):
    
    echo $this->Form->create('Conversation', array('url'=>'/contents/post_comment')); 
    echo $this->Form->input('content_id', array('type'=>'hidden', 'value'=>$post['Post']['id'])); 
    echo $this->Form->input('body', 
        array(
            'class'=>'comment', 
            'style'=>'width:98%;', 
            'rows'=>6,
            'value'=> isset($post_comment)? $post_comment:'',
            'label'=>array('text'=>'Comment', 'style'=>'display:block;'))); 
    echo $this->Form->submit(); 
    echo $this->Form->end(); 
    
else:
    
    echo $this->Html->Tag('h2', __('Leave a Comment'));
    echo 'Sign In | Twitter | Facebook | LinkedIn | Create an Account' ;
     
endif;
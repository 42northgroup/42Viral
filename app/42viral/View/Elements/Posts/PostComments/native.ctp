<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
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

echo $this->Html->Tag('h2', __('Leave a Comment'));

echo $this->Form->create('Conversation', array('url'=>$this->here, 'class'=>'conversation')); 

echo $this->Form->input('content_id', array('type'=>'hidden', 'value'=>$post['Post']['id']));

echo $this->Form->input('name');

echo $this->Form->input('email'); 

echo $this->Form->input('uri', array('label'=>'Website'));

    echo $this->Form->input('body', 
    array(
        'class'=>'comment',  
        'rows'=>9,
        'value'=> isset($post_comment)? $post_comment:'',
        'label'=>array('text'=>'Comment'))); 

echo $this->Form->input('user_ip', 
        array(
            'type'=>'hidden',
            'value'=>env('REMOTE_ADDR')));

echo $this->Form->input('user_agent', 
        array(
            'type'=>'hidden',
            'value'=>env('HTTP_USER_AGENT')));    

echo $this->Form->input('referrer', 
        array(
            'type'=>'hidden',
            'value'=>env('HTTP_REFERER')));  

echo $this->Form->input('front_page', 
    array(
        'type'=>'hidden',
        'value'=>Configure::read('Domain.url') . '/blog/'));

echo $this->Form->input('permalink', 
        array(
            'type'=>'hidden',
            'value'=>
                Configure::read('Domain.url') . "/conversation/" . String::uuid() . "/"));   

echo $this->Form->input('comment_type', 
        array(
            'type'=>'hidden',
            'value'=>'comment')); 



echo $this->Form->submit(); 
echo $this->Form->end(); 

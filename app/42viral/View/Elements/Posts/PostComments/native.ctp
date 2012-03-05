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
    
    echo $this->Html->Tag('h2', __('Leave a Comment'));
    echo $this->Form->create('Conversation', array('url'=>$this->here)); 
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

    echo $this->Form->create('Conversation', array('url'=>$this->here)); 
    
    echo $this->Form->input('content_id', array('type'=>'hidden', 'value'=>$post['Post']['id']));
    
    echo $this->Form->input('name');
    
    echo $this->Form->input('email'); 
    
    echo $this->Form->input('url');
    
     echo $this->Form->input('body', 
        array(
            'class'=>'comment', 
            'style'=>'width:98%;', 
            'rows'=>6,
            'value'=> isset($post_comment)? $post_comment:'',
            'label'=>array('text'=>'Comment', 'style'=>'display:block;'))); 
    
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
     
endif;

/*
'blog' => 'https://build.42viral.org/post/backing-up-the-backups-cloud-storage-and-redundancy',
--'user_ip' => gethostbyaddr(env('REMOTE_ADDR')),
--'user_agent' => env('HTTP_USER_AGENT'),
--'referrer' => 'http://www.google.com',
--'permalink' => 'http://yourblogdomainname.com/blog/post=1',
--'comment_type' => 'comment',
'comment_author' => $this->data['Conversation']['name'],
'comment_author_email' => $this->data['Conversation']['email'],
'comment_author_url' => 'https://jasonsnider.com',
'comment_content' =>  $this->data['Conversation']['body']
 */
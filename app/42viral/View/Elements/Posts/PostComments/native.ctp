<?php echo $this->Form->create('Conversation', array('url'=>'/contents/post_comment')); ?>
<?php echo $this->Form->input('content_id', array('type'=>'hidden', 'value'=>$post['Post']['id'])); ?>
<?php echo $this->Form->input('body', 
        array(
            'class'=>'comment', 
            'style'=>'width:98%;', 
            'rows'=>6,
            'value'=> isset($post_comment)? $post_comment:'',
            'label'=>array('text'=>'Comment', 'style'=>'display:block;'))); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>
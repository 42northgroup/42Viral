<style type="text/css">
    .post-avatar{
        float:left; padding:8px 0 0; height:128px; width:138px;
    }
    
    .post h1{
        padding:0; 
        margin:0;
    }
    
    .post-body{
        margin-top: 6px;
    }
    
    .meta{
        font-style: italic;
        color:#555;
    }
    
    .meta-head{
        font-style: normal;
        font-weight: bold;
    }
</style>


<div class="post clearfix">
    <div class="post-avatar">
        <?php echo $this->Member->avatar($post['CreatedPerson']); ?>
    </div>

    <h1><?php echo $post['Post']['title']; ?></h1>
    
    <div class="meta">
        <span class="meta-head">Posted:</span>
        <?php echo $this->Member->displayName($post['CreatedPerson']); ?>
        &nbsp;<?php echo $post['Post']['created']; ?>

    </div>
    <div class="post-body"><?php echo $post['Post']['body']; ?></div>
</div>

<div class="meta" style="margin: 6px 0;">
    <span class="meta-head">Last Modified:</span>
    <?php echo $post['Post']['modified']; ?>
</div>

<?php echo $this->element('Posts' . DS . 'post_comments'); ?>
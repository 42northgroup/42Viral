<div class="clearfix">
    
    <h1 style="float:left;"><?php echo $blog['Blog']['title']; ?></h1>
    
    <div style="float:right; margin:6px 0 0;">
        <?php
            if($mine):
                echo $this->Html->link('Edit', "/contents/blog_edit/{$blog['Blog']['id']}");
                echo ' / ';
                echo $this->Html->link('Delete', "/contents/blog_delete/{$blog['Blog']['id']}", null,
                        'Are you sure you want to delete this? \n This action CANNOT be reversed!'); 
            endif; 
        ?>
    </div>
    
</div>

<div><?php echo $blog['Blog']['tease']; ?></div>

<div id="ResultsPage">
    <?php foreach($blog['Post'] as $post): ?>
        <h2><?php echo $this->Html->link($post['title'], $post['url']); ?></h2>
        <div class="tease"><?php echo $post['tease']; ?></div>
    <?php endforeach; ?>
</div>


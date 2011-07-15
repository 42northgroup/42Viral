<h1>Blogs</h1>

<?php foreach($blogs as $blog): ?>
    <div><?php echo $this->Html->link($blog['Blog']['title'], "/blogs/posts/{$blog['Blog']['slug']}"); ?></div>
<?php endforeach; ?>


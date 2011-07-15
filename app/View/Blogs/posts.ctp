<h1><?php echo $blog['Blog']['title']; ?></h1>

<?php foreach($blog['Post'] as $post): ?>
    <div><?php echo $this->Html->link($post['title'], "/blogs/post/{$post['slug']}"); ?></div>
<?php endforeach; ?>


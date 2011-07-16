<h1>Blogs</h1>

<?php foreach($blogs as $blog): ?>
    <div><?php echo $this->Html->link($blog['Blog']['title'], $blog['Blog']['url']); ?></div>
<?php endforeach; ?>


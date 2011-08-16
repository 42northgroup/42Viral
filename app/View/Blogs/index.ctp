<h1>Blogs</h1>

<?php foreach($blogs as $blog): ?>
    <h2><?php echo $this->Html->link($blog['Blog']['title'], $blog['Blog']['url']); ?></h2>
<?php endforeach; ?>
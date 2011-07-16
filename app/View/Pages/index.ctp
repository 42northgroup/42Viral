<h1>Pages</h1>

<?php foreach($pages as $page): ?>
    <div><?php echo $this->Html->link($page['Page']['title'], "/pages/view/{$page['Page']['slug']}"); ?></div>
<?php endforeach; ?>


<h1><?php echo $blog['Blog']['title']; ?></h1>
<div><?php echo $blog['Blog']['tease']; ?></div>

<?php foreach($blog['Post'] as $post): ?>
    <h2><?php echo $this->Html->link($post['title'], $post['url']); ?></h2>
    <div><?php $post['tease']; ?></div>
<?php endforeach; ?>


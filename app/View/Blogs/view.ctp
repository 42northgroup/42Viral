<h1 style="margin-bottom: 2px;"><?php echo $blog['Blog']['title']; ?></h1>
<div style="margin-bottom: 12px;"><?php echo $blog['Blog']['tease']; ?></div>

<?php foreach($blog['Post'] as $post): ?>
    <h2 style="margin-bottom: 2px;"><?php echo $this->Html->link($post['title'], $post['url']); ?></h2>
    <div style="margin-bottom: 6px;"><?php echo $post['tease']; ?></div>
<?php endforeach; ?>


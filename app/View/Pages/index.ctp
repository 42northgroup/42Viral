<div id="ResultsPage">
    <h1>Pages</h1>
    <?php foreach($pages as $page): ?>
        <h2><?php echo $this->Html->link($page['Page']['title'], $page['Page']['url']); ?></h2>
        <div class="tease"><?php echo $page['Page']['tease']; ?></div>
    <?php endforeach; ?>
</div>


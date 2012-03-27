<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <div id="ResultsPage">    
            <?php foreach($pages as $page): ?>
            <div class="result">
                <h2><?php echo $this->Html->link($page['Page']['title'], $page['Page']['edit_url']); ?></h2>
                <div class="tease"><?php echo $page['Page']['tease']; ?></div>
                <div class="controls">
                    <?php echo $this->Html->link(
                            'Delete', $page['Page']['delete_url'], null, 
                            Configure::read('System.purge_warning')); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="one-third column omega"></div>
</div>
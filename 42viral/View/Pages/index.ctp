<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'')); ?>

<div id="ResultsPage">    
    <?php foreach($pages as $page): ?>
    <div class="result">
        <h2><?php echo $this->Html->link($page['Page']['title'], $page['Page']['edit_url']); ?></h2>
        <div class="tease"><?php echo $page['Page']['tease']; ?></div>
        <!-- <div class="controls"></div> -->
    </div>
    <?php endforeach; ?>
</div>


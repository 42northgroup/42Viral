<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'')); ?>

<div id="ResultsPage">    
    <?php foreach($plugins as $plugin): ?>
        <div><?php echo $this->Html->link($plugin['label'], $plugin['uri']); ?></div>
    <?php endforeach; ?>
</div>

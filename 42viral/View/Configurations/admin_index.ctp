<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'')); ?>

<div id="ResultsPage">    
    <?php foreach($plugins as $plugin): ?>
        <div><?php echo $plugin; ?></div>
    <?php endforeach; ?>
</div>

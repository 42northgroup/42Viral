<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>

    <?php //echo View::getVar('canonical_for_layout'); ?>

    <?php
        echo $this->Html->meta('icon');
        
        echo $this->Html->css('vendors/yui');
        echo $this->Html->css('cake.stripped');
        echo $this->Html->css('default');
        
        echo $scripts_for_layout;
    ?>
</head>
    <body>
        <div id="Container">
            <?php echo $this->Session->flash(); ?>
            
            <?php echo $this->element('Blocks' . DS . 'header'); ?>
            
            <?php echo $this->element('Blocks' . DS . 'banner'); ?>
            
            <div id="Wrapper" class="clearfix">
                
                
                <div id="Left"><?php echo $this->element('Blocks' . DS . 'left'); ?></div>
                
                <div id="Content"><?php echo $content_for_layout; ?></div>
                
                <div id="Right"><?php echo $this->element('Blocks' . DS . 'right'); ?></div>
                
            </div>
            
            <div id="Footer"><?php echo $this->element('Blocks' . DS . 'footer'); ?></div>
        </div> 
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
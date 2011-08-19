<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo $this->element('Blocks' . DS . 'html_head'); ?>

    <?php
        echo $this->Html->meta('icon');
        
        $this->Asset->addAssets(array(
                    'js' . DS . 'vendors' . DS . 'modernizr.js',
                    'js' . DS . 'vendors' . DS . 'jquery.js',
                    'js' . DS . 'engine.js',
            
                    'css' . DS . 'vendors' . DS . 'yui.css',
                    'css' . DS . 'cake.stripped.css',
                    'css' . DS . 'layout.css',
                ));

        echo $this->Asset->buildAssets('js');
        echo $this->Asset->buildAssets('css');
    ?>
</head>
    <body>
        <div id="Container">
            <?php echo $this->Session->flash(); ?>
            
            <?php echo $this->element('Blocks' . DS . 'header'); ?>
            
            <?php echo $this->element('Blocks' . DS . 'banner'); ?>

            <div id="Main">
                
                <div id="MainLeft"><?php echo $this->element('Blocks' . DS . 'left'); ?></div>
                
                <div id="MainContent"><?php echo $content_for_layout; ?></div>
                
                <div id="MainRight"><?php echo $this->element('Blocks' . DS . 'right'); ?></div>
                
            </div>
            
            <div id="Footer"><?php echo $this->element('Blocks' . DS . 'footer'); ?></div>
            
        </div> 
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

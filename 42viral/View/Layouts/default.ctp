<!DOCTYPE html>
<html lang="en">
    <head>

        <?php echo $this->element('Blocks' . DS . 'html_head'); ?>

        <?php
            echo $this->Html->meta('icon');

            $this->Asset->addAssets(array(
                'vendors' . DS . 'modernizr' . DS . 'js' . DS . 'modernizr.js',
                'vendors' . DS . 'jquery' . DS . 'js' . DS . 'jquery.js',

                'vendors' . DS . 'misc' . DS . 'js' . DS . 'jquery.Jcrop.js',

                'js' . DS . 'startup.js',

                
                'vendors' . DS . 'yui' . DS . 'css' . DS . 'yui.css',
                'vendors' . DS . 'html5boilerplate' . DS . 'css' . DS . 'style.css',
                'vendors' . DS . 'skeleton' . DS . 'css' . DS . 'skeleton.css',

                'css' . DS . 'cake.stripped.css',
                'css' . DS . 'layout.css',
                'css' . DS . 'basics.css',
                
                'css' . DS . 'responsive-header.css',
                'css' . DS . 'responsive-navigation.css',
                'css' . DS . 'responsive-form.css',

                'css' . DS . 'hcard.css',

                'css' . DS . 'tables.css',
                'css' . DS . 'messages.css',

                'css' . DS . 'controls.css',
                'css' . DS . 'controls.social.css',
                
                'vendors' . DS . 'misc' . DS . 'css' . DS . 'jquery.Jcrop.css',
                'css' . DS . 'fonts.css'
            ));

            echo $this->Asset->buildAssets('js');
            echo $this->Asset->buildAssets('css'); 
        ?>
    </head>
    <body>
        <div id="Container">
            <?php echo $this->Session->flash(); ?>
            
            <?php echo $this->element('Blocks' . DS . 'header'); ?>
            
            <div id="Main" class="clearfix container">
                <?php echo $content_for_layout; ?>
            </div>

            <?php echo $this->element('Blocks' . DS . 'footer'); ?>
            
        </div> 
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

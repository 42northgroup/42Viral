<!DOCTYPE html>
<html lang="en">
    <head>

        <?php echo $this->element('Blocks' . DS . 'html_head'); ?>
        
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allan:bold">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Just+Another+Hand">
        <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Reenie+Beanie">
        <?php
            echo $this->Html->meta('icon');

            $this->Asset->addAssets(array(
                        'js' . DS . 'vendors' . DS . 'modernizr.js',
                        'js' . DS . 'vendors' . DS . 'jquery.js',
                        'js' . DS . 'engine.js',

                        'css' . DS . 'vendors' . DS . 'yui.css',
                        'css' . DS . 'cake.stripped.css',
                        'css' . DS . 'home.css',
                    ));

            echo $this->Asset->buildAssets('js');
            echo $this->Asset->buildAssets('css');
        ?>

    </head>
    <body>
        <?php echo $this->Session->flash(); ?>

        <?php echo $this->element('Blocks' . DS . 'header'); ?>

        <div id="ProfileWrapper" class="clearfix">

            <div id="Content"><?php echo $content_for_layout; ?></div>

        </div>

        <div id="Footer"><?php echo $this->element('Blocks' . DS . 'footer'); ?></div>   
        
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
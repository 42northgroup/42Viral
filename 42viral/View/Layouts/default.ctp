<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>

        <?php echo $this->element('Blocks' . DS . 'html_head'); ?>

        <?php
            echo $this->Html->meta('icon');

            $this->Asset->addAssets(array(
            	CURRENT_JQUERY,
                CURRENT_MODERNIZR,
                'vendors' . DS . 'misc' . DS . 'js' . DS . 'jquery.Jcrop.js',

                'js' . DS . 'startup.js',


                'vendors' . DS . 'yui' . DS . 'css' . DS . 'yui.css',
                'vendors' . DS . 'html5boilerplate' . DS . 'css' . DS . 'style.css',
                'vendors' . DS . 'skeleton' . DS . 'css' . DS . 'skeleton.css',

                'css' . DS . 'cake.stripped.css',
                'css' . DS . 'basics.css',

                'css' . DS . 'responsive-layout.css',
                'css' . DS . 'responsive-elements.css',

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

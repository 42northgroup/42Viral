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

            $this->Asset->addAssets(
                array(
                	'vendors' . DS . 'jquery' . DS . 'js' . DS . 'jquery-1.7.2.js',
                    'vendors' . DS . 'jquery-ui' . DS . 'js' . DS . 'jquery-ui-1.8.21.custom.min.js',
                    'vendors' . DS . 'jquery-ui-timepicker-addon' . DS . 'js' . DS . 'jquery-ui-timepicker-addon.js',
                    'vendors' . DS . 'modernizr' . DS . 'js' . DS . 'modernizr.js',
                    'js' . DS . 'startup.js',


                    'vendors' . DS . 'normalize' . DS . 'css' . DS . 'normalize.css',
                    'vendors' . DS . 'skeleton' . DS . 'css' . DS . 'skeleton.css',

                    'css' . DS . 'cake.stripped.css',
                    'css' . DS . 'basics.css',

                    'css' . DS . 'responsive-layout.css',
                    'css' . DS . 'responsive-elements.css',

                    'css' . DS . 'responsive-header.css',
                    'css' . DS . 'responsive-navigation.css',
                    'css' . DS . 'responsive-form.css',

                    'css' . DS . 'tables.css',
                    'css' . DS . 'messages.css',

                    'css' . DS . 'controls.css',
                    'css' . DS . 'controls.social.css',

                    'css' . DS . 'fonts.css',

                    'vendors' . DS . 'jquery-ui-timepicker-addon' . DS . 'css' . DS . 'jquery-ui-timepicker-addon.css'
                )
            );

            echo $this->Asset->buildAssets('js');
            echo $this->Asset->buildAssets('css');

            echo $this->Html->css(
                array(
                    DS . 'vendors' .
                    DS . 'jquery-ui' .
                    DS . 'css' .
                    DS . 'ui-lightness' .
                    DS . 'jquery-ui-1.8.21.custom.css'
                )
            );
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

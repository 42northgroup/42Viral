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

        echo $this->Asset->buildAssetPackage('jquery');

        $this->Asset->addAssets(array(
            'vendors' . DS . 'modernizr' . DS . 'js' . DS . 'modernizr.js',
            'js' . DS . 'startup.js',

            'vendors' . DS . 'yui' . DS . 'css' . DS . 'yui.css',
            'vendors' . DS . 'html5boilerplate' . DS . 'css' . DS . 'style.css',
            'vendors' . DS . 'skeleton' . DS . 'css' . DS . 'skeleton.css',

            'css' . DS . 'fonts.css',

            'css' . DS . 'responsive-header.css',
            'css' . DS . 'responsive-navigation.css',
            'css' . DS . 'responsive-form.css',


            'css' . DS . 'forms.css',
            'css' . DS . 'navigation.css',

            'css' . DS . 'cake.stripped.css',
            'css' . DS . 'layout.css',
            'css' . DS . 'basics.css',

            'css' . DS . 'tables.css',
            'css' . DS . 'messages.css',

            'css' . DS . 'controls.css',
            'css' . DS . 'controls.social.css'
        ));

        echo $this->Asset->buildAssets('js');
        echo $this->Asset->buildAssets('css');
    ?>

    <style type="text/css">
        pre {
            color: #000;
            background: #f0f0f0;
            padding: 15px;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        pre,
        code {
            overflow: auto;
            font-size: 12px;
        }
    </style>
</head>
    <body>
        <div id="Container">
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->element('Blocks' . DS . 'header_blank'); ?>

            <div id="Main">
                <div class="clearfix squeeze">

                    <div id="MainContent">
                        <?php echo $content_for_layout; ?>
                    </div>

                </div>
            </div>

            <div id="Footer"><?php echo $this->element('Blocks' . DS . 'footer'); ?></div>

        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * UI for creating a web page
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <?php
            $this->Asset->addAssets(array(
                'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
                'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
                'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
            ), 'ck_editor');

            echo $this->Asset->buildAssets('js', 'ck_editor', false);

            echo $this->Form->create('Page', 
                        array(
                            'url'=>$this->here, 
                            'class'=>'responsive'
                        )
                    );

            echo $this->Form->input('id');
            echo $this->Form->input('title', array('rows'=>1));
            echo $this->Form->input('body', array('class'=>'edit-content'));
            echo $this->Form->input('tease', array('class'=>'edit-content'));
            echo $this->Form->input('description');
            echo $this->Form->input('keywords');
            echo $this->Form->input('tags');
            echo $this->Form->input('canonical', array('rows'=>1));
            echo $this->Form->input('slug', array('rows'=>1));

            echo $this->Form->inputs(
                    array('legend'=>'Sitemap',
                        'Sitemap.id',
                        'Sitemap.priority'=>array('options'=>Configure::read('Picklist.Sitemap.priority')),
                        'Sitemap.changefreq'=>array('options'=>Configure::read('Picklist.Sitemap.changefreq'))));

            echo $this->Form->input('status');
            echo $this->Form->submit();
            echo $this->Form->end();
        ?>
    </div>
</div>
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

<?php echo $this->Asset->buildAssetPackage('ck_editor'); ?>
<?php echo $this->Asset->buildAssetPackage('selectit'); ?>

<script type="text/javascript">
$(function () {
    $('#BlogTitle').focus();

    $('#TagsContainer').selectit({
        targetFieldId: 'BlogTags',
        proxyFieldId: 'BlogTagsProxy',
        values: (function() {
            var tags = "<?php echo $this->data['Blog']['tags']; ?>".split(',');
            var cleanTags = [];

            for(var i in tags) {
                if(tags.hasOwnProperty(i)) {
                    if(tags[i] != "") {
                        cleanTags.push(tags[i]);
                    }
                }
            }

            return cleanTags;
        })()
    });

    // "Instansiates prototypical objects"
    $(function(){
        SetEditor.init({
            syntax: '<?php echo $this->data['Blog']['syntax']; ?>',
            element: 'BlogBody'
        });
    });
});
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="row">
    <?php
    echo $this->Form->create('Blog', array(
        'url' => $this->here,
        'class' => 'responsive'
    ));

    $this->Form->unlockField('Blog.tags');
    ?>

    <div class="two-thirds column alpha">

    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1));
    echo $this->Form->input('syntax', array('type' => 'hidden'));
    echo $this->Form->input('body', array('class'=>'content-edit'));
    ?>

    <div class="input text">
        <label for="PageTagsProxy">Tags</label>
        <span>(Separate with comma)</span>
        <div id="TagsContainer"></div>
    </div>

    <?php
    echo $this->Form->text('tags_proxy', array(
        'maxlength' => '30'
    ));
    echo $this->Form->hidden('tags');
    ?>

    <?php

    echo $this->Form->inputs(array(
            'legend'=>'SEO',
            'canonical'=>array('rows'=>1),
            'slug'=>array('rows'=>1)
            )
        );

    ?>
    </div>
    <div class="one-third column omega">
        <?php
            //We only want authorized users to be able to set site map settings
            if($this->Session->read('Auth.User.employee') == 1):
                echo $this->Form->inputs(
                        array('legend'=>'Sitemap',
                            'Sitemap.id',
                            'Sitemap.model'=>array('value'=>'Blog', 'type'=>'hidden'),
                            'Sitemap.priority'=>array('options'=>Configure::read('Picklist.Sitemap.priority')),
                            'Sitemap.changefreq'=>array('options'=>Configure::read('Picklist.Sitemap.changefreq'))));
            endif;

            echo $this->Form->inputs(array('legend'=>'Publish', 'status'));
            echo $this->Form->submit();
        ?>
    </div>

    <?php echo $this->Form->end(); ?>
</div>
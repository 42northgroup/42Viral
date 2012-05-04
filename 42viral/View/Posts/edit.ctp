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

<script type="text/javascript">
$(function() {
    $('#PostTitle').focus();
});
</script>

<h1><?php echo $title_for_layout; ?></h1>

<?php echo $this->Asset->buildAssetPackage('ck_editor'); ?>
<?php echo $this->Asset->buildAssetPackage('selectit'); ?>

<script type="text/javascript">
$(function () {
    $('#TagsContainer').selectit({
        targetFieldId: 'PostTags',
        proxyFieldId: 'PostTagsProxy',
        values: (function() {
            var tags = "<?php echo $this->data['Post']['tags']; ?>".split(',');
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
            syntax: '<?php echo $this->data['Post']['syntax']; ?>',
            element: 'PostBody'
        });
    });
});
</script>

<?php
echo $this->Form->create('Post', array(
    'url' => $this->here, 
    'class' => 'responsive',
    'type' => 'file'
));

$this->Form->unlockField('Post.tags');
?>

<div class="row">
    <div class="two-thirds column alpha">

    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('title', array('rows'=>1));
    echo $this->Form->input('tease', array('rows'=>2));
    echo $this->Form->input('syntax', array('type' => 'hidden'));
    ?>
        
    <div class="or-group">
        <h3>Load body content by uploading a file or typing in the editor:</h3>
        <div class="or-choice">
            <?php
            echo $this->Form->input('body_content_file', array(
                'type' => 'file',
                'label' => 'Upload from file'
            ));
            ?>
        </div>

        <h3>OR</h3>

        <div class="or-choice">
            <?php
            echo $this->Form->input('body', array(
                'label' => 'Type'
            ));
            ?>
        </div>
    </div>


    <div class="input text">
        <label for="PostTagsProxy">Tags</label>
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
        
            /*
            echo $this->Form->inputs(
                    array('legend'=>'Sitemap',
                        'Sitemap.id',
                        'Sitemap.priority'=>array('options'=>Configure::read('Picklist.Sitemap.priority')),
                        'Sitemap.changefreq'=>array('options'=>Configure::read('Picklist.Sitemap.changefreq'))));
            */
            
            echo $this->Form->inputs(array('legend'=>'Publish', 'status'));
            echo $this->Form->submit();
        ?>
    </div>
</div>
<?php echo $this->Form->end(); ?>

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
    $('#BlogTitle').focus();
});
</script>

<h1><?php echo $title_for_layout; ?></h1>

<div class="rows">
    <?php
        echo $this->Form->create('Blog',
                    array(
                        'url'=>$this->here,
                        'class'=>'responsive'
                    )
                );
    ?>

    <div class="two-thirds column alpha">
    <?php
        echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));


    ?>
    </div>
    <div class="one-third column omega">
    <?php
        echo $this->Form->input('syntax');
        echo $this->Form->input('post_access');
        echo $this->Form->submit();
    ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>
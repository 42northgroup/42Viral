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

/**
 * UI for creating a web page
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="rows">
    <div class="sixteen columns">
    <?php
        echo $this->Form->create('Blog', 
                    array(
                        'url'=>$this->here, 
                        'class'=>'responsive'
                    )
                );

        echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
        echo $this->Form->submit();
        echo $this->Form->end();
    ?>
    </div>
</div>
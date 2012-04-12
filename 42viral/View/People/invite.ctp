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
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="eight columns alpha omega">
        <?php 
        echo $this->Form->create('Invite', array(
            'url' => $this->here,
            'class' => 'responsive'
        )); 
        
        echo $this->Form->input('emails', array(
            'label' => 'Emails(comma separated)'
        ));
        
        echo $this->Form->input('message', array(
            'type' => 'textarea'
        ));
        
        echo $this->Form->end('Submit');
        ?>
        
    </div>
</div>
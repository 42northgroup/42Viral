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
    <div class="two-thirds column alpha">
        <?php

            echo $this->Form->create('SocialNetwork', 
                        array(
                            'url'=>$this->here, 
                            'class'=>'responsive'
                        )
                    );

            echo $this->Form->input('id');
            echo $this->Form->input('network');
            echo $this->Form->input('profile');

            echo $this->Form->submit();

            echo $this->Form->end();

        ?>
    </div>
    <div class="one-third column omega">
        <div class="column-block">
            <h4>Manage Social Networks</h4>
            <div class="navigation-block block-links">
                
                <?php echo $this->Html->link(__('Your Social Networks'), 
                        '/social_networks/index/' . $this->Session->read('Auth.User.Profile.id')); ?>
                
                <?php echo $this->Html->link(__('Add a Social Network'), 
                        '/social_networks/create/' . $this->Session->read('Auth.User.Profile.id')); ?>
                
            </div>
        </div>
    </div>
</div>

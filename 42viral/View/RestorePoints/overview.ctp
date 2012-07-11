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

App::uses('Scrub', 'Lib');
?>
<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">

        <?php
            if(!empty($restore_point)) {
                if (!empty($restore_point['RestorePoint']['json_object'])) {
                   $restored = json_decode($restore_point['RestorePoint']['json_object']);
                   echo '<h1>' . $restored->{$restore_model}->title . '</h1>';
                    switch($restored->{$restore_model}->syntax):
                        case 'markdown':
                            echo Scrub::htmlMedia(Utility::markdown($restored->{$restore_model}->body));
                        break;

                        default:
                            echo $restored->{$restore_model}->body;
                        break;
                    endswitch;
                }
            }
	        else { ?>
                <div class="no-results">
                    <div class="no-results-message">
                        <?php echo __("I'm sorry, there is no restore point to display."); ?>
                    </div>
                </div>
        <?php } ?>

    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus',
            array('section'=>strtolower($restore_model)));
        ?>
    </div>
</div>
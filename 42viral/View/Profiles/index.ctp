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
        <div>
            <?php foreach($users as $user):?>
                <div class="result">
                    <div>
                        <div class="image-frame" style="vertical-align: top; margin-right: 6px;">
                            <?php echo $this->Profile->avatar($user['User'], 64); ?>
                        </div>
                        <strong><?php echo $this->Profile->displayName($user['User']); ?></strong>
                        <?php
                        echo Scrub::noHtml(
                            $this->Text->truncate(
                                $user['Profile']['bio'],
                                170,
                                array(
                                    'ending' => '...',
                                    'exact' => true,
                                    'html' => true
                                )
                            )
                        );
                        ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="one-third column omega">asdf</div>
</div>

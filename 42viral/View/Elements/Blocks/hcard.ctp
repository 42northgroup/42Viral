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
?>
<?php if(isset($userProfile)):?>
    <div class="column-block clearfix">

        <div class="image-frame" style="float:left; margin: 0 6px 6px 0;">
            <?php echo $this->Member->avatar($userProfile['Person']); ?>
            <div class="image-title">
                <span class="fn"><?php echo $this->Member->name($userProfile['Person']); ?></span>
            </div>
        </div>

        <div>
            <?php echo $userProfile['Person']['Profile']['bio']; ?>
        </div>

    </div>
<?php endif; ?>
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

        <div style="float:left;">
            <?php echo $this->Member->avatar($userProfile['Person']); ?>
        </div>

        <div>
            <h4 class="fn" style="display:inline;">
                <?php echo $this->Member->name($userProfile['Person']); ?>
            </h4>
            <?php echo $userProfile['Person']['Profile']['bio']; ?>
        </div>

    </div>
<?php endif; ?>
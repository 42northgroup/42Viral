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
<div class="column-block">
    <div class="navigation-block">
        <?php 
            if(isset($userProfile)):

                echo $this->Html->link('Profile', $userProfile['Person']['url']);                
                echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}");
            else:
                echo '&nbsp;';
            endif; 
        ?> 
    </div>
</div>


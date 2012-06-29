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
<?php if($this->Session->read('Auth.User.employee') == 1): ?>
    <!-- Employee footer -->
    <div class="container">
        <div class="rows">
            <div class="four columns alpha">
                <div class="navigation-block block-links">
                    <a href="/admin">Admin</a>
                </div>
            </div>
            <div class="four columns">
                <div class="navigation-block block-links">&nbsp;</div>
            </div>
            <div class="four columns">
                <div class="navigation-block block-links">&nbsp;</div>
            </div>
            <div class="four columns omega">
                <div class="navigation-block block-links">&nbsp;</div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Standard footer -->
<div id="Footer">
    <div class="container">
        <div class="rows">
            <div class="sixteen columns alpha omega">
                Powered by <a href="">The 42Viral Project</a>
            </div>
        </div>
    </div>
</div>
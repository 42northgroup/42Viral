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
<div class="container">
    <div class="rows">
        <div class="sixteen columns alpha omega">
        <?php if($this->Session->read('Auth.User.employee') == 1): ?>
            <a href="/admin">Admin</a>
        <?php endif; ?>
        </div>
    </div>
</div>

<div id="Footer">
    <div class="container">
        <div class="rows">
            <div class="sixteen columns alpha omega">
                Powered by <a href="">The 42Viral Project</a>
            </div>
        </div>
    </div>
</div>
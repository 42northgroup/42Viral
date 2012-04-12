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
<?php if($this->Session->check('Auth.User.id')): ?>

    <h4>Content Management</h4>
    
    <ul class="side-navigation">
        <li><a href="/contents/content">Content</a></li>
        <li><a href="/blogs/create">Blog</a></li>
        <li><a href="/contents/post_create">Post</a></li>
        <li><a href="/contents/page_create">Page</a></li>
    </ul>

<?php endif; ?>
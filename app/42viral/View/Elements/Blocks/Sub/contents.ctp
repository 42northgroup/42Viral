<?php if($this->Session->check('Auth.User.User.id')): ?>

    <h4>Content Management</h4>
    
    <ul class="side-navigation">
        <li><a href="/contents/content">Content</a></li>
        <li><a href="/contents/blog_create">Blog</a></li>
        <li><a href="/contents/post_create">Post</a></li>
        <li><a href="/contents/page_create">Page</a></li>
    </ul>

<?php endif; ?>
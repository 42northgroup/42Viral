<ul class="side-navigation">
    <li><a href="/pages">Pages</a></li>
    <li><a href="/blogs">Blogs</a></li>
</ul>

<?php if($this->Session->check('Auth.User.User.id')): ?>

    <hr />

    <ul class="side-navigation">
        <li><a href="/profiles/content">Content</a></li>
        <li><a href="/profiles/blog_create">Blog</a></li>
        <li><a href="/profiles/post_create">Post</a></li>
        <li><a href="/profiles/page_create">Page</a></li>

        <li><a href="/profiles">Profiles</a></li>
    </ul>

<?php endif; ?>
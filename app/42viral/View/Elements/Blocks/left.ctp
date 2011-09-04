<?php if(isset($user['User'])): ?>
    <div class="avatar">
        <?php echo $this->Member->avatar($user['User']) ?>
    </div>
<?php endif; ?>

<ul class="side-navigation">
    <li><a href="/pages">Pages</a></li>
    <li><a href="/blogs">Blogs</a></li>
    <li><a href="/members">Members</a></li>
    <li><a href="/companies">Companies</a></li>
    <li><a href="/admin/users/">Users Index</a></li>
    <li><a href="/users/social_media">Social Media</a></li>
</ul>
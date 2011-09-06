<?php if(isset($userProfile)): ?>
    <div class="avatar">
        <?php echo $this->Member->avatar($userProfile['Person']) ?>
    </div>
<?php endif; ?>

<ul class="side-navigation">
    <li><a href="/pages">Pages</a></li>
    <li><a href="/blogs">Blogs</a></li>
    <li><a href="/members">Members</a></li>
    <li><a href="/companies">Companies</a></li>
</ul>

<h4 style="margin: 8px 0 0;">Admin</h4>
<ul class="side-navigation">
    <li><a href="/admin/users/">Users</a></li>
</ul>
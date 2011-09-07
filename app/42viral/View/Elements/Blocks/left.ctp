<?php if(isset($userProfile)): ?>
    <div class="avatar">
        <?php echo $this->Member->avatar($userProfile['Person']) ?>
    </div>
<?php endif; ?>

<ul class="side-navigation">
    <li><?php echo $this->Html->link('Blogs', '/blogs'); ?></li>
    <li><?php echo $this->Html->link('Members', '/members'); ?></li>
    <li><?php echo $this->Html->link('Companies', '/companies'); ?></li>
    <li><?php echo $this->Html->link('Pages', '/pages'); ?></li>
</ul>

<h4 style="margin: 8px 0 0;">Admin</h4>
<ul class="side-navigation">
    <li><a href="/admin/users/">Users</a></li>
</ul>
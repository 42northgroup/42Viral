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


<?php if($this->Session->check('Auth.User.id')): ?>
    <?php if($this->Session->read('Auth.User.employee') == 1): ?>
    <h4 style="margin: 8px 0 0;">Admin</h4>
    <ul class="side-navigation">
        <li><?php echo $this->Access->link('Users-admin_index', 'Users', '/admin/users'); ?></li>
        <li><?php echo $this->Access->link('Contents-page_create', 'Create a web page', '/contents/page_create/'); ?></li>
    </ul>
    <?php endif; ?>
<?php endif; ?>
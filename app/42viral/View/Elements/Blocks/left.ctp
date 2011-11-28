<?php if(isset($userProfile)): ?>
    <div class="avatar">
        <?php echo $this->Member->avatar($userProfile['Person']) ?>
    </div>
<?php endif; ?>
<h4 class="side-navigation-header">
    <a href="#">Menu</a> 
    <span class="side-navigation-toggle">&#9660;</span>
</h4>
<ul class="side-navigation" style="display: block;">
    <li><a href="/blogs">Blogs</a></li>
    <li><a href="/members">Members</a></li>
    <li><a href="/companies">Companies</a></li>
    <li><a href="/pages">Pages</a></li>
</ul>

<?php if($this->Session->check('Auth.User.id')): ?>
    <?php if($this->Session->read('Auth.User.employee') == 1): ?>

        <h4 class="side-navigation-header side-navigation-divider">
            <a href="#">CMS</a> 
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li>
                <?php
                echo $this->Access->link('Contents-page_create', 'Create a web page', '/contents/page_create/');
                ?>
            </li>
        </ul>

        <h4 class="side-navigation-header">
            <a href="#">CRM</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Access->link('People-admin_index', 'People', '/admin/people'); ?></li>
        </ul>

        <h4 class="side-navigation-header side-navigation-divider">
            <a href="#">Messaging</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Access->link('Notification-index', 'Notifications', '/notification/index'); ?></li>
            <li><?php echo $this->Access->link('Notification-create', ' - Create', '/notification/create'); ?></li>
            <li><?php echo $this->Access->link('People-invite', 'Invite a Friend', '/people/invite'); ?></li>
        </ul>

        <h4 class="side-navigation-header">
            <a href="#">System</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Access->link('Users-admin_index', 'Users', '/admin/users'); ?></li>
            <li><?php echo $this->Access->link('Users-admin_acl_groups', 'Groups', '/admin/users/acl_groups'); ?></li>
            <li><?php echo $this->Access->link('Picklists-admin_index', 'Picklists', '/admin/picklists/index'); ?></li>
        </ul>

    <?php endif; ?>
<?php endif; ?>
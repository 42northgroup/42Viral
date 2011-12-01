<?php if(isset($userProfile)): ?>
    <div class="avatar">
        <?php echo $this->Member->avatar($userProfile['Person']) ?>
    </div>
<?php endif; ?>
<h4 id="Menu" class="side-navigation-header side-navigation-divider">
    <a href="#">Menu</a> 
    <span class="side-navigation-toggle">&#9660;</span>
</h4>
<ul class="side-navigation" style="display: block;">
    <li><a href="/blogs">Blogs</a></li>
    <li><a href="/members">Members</a></li>
    <li><a href="/profile_companies">Companies</a></li>
    <li><a href="/pages">Pages</a></li>
</ul>

<?php if($this->Session->check('Auth.User.id')): ?>
    <?php if($this->Session->read('Auth.User.employee') == 1): ?>

        <h4 id="CMS" class="side-navigation-header side-navigation-divider">
            <a href="#">CMS</a> 
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li>
                <?php
                echo $this->Html->link('Create a web page', '/contents/page_create/');
                ?>
            </li>
        </ul>

        <h4 id="CRM" class="side-navigation-header">
            <a href="#">CRM</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Html->link('People', '/admin/people'); ?></li>
            <li><?php echo $this->Html->link('Companies', '/admin/companies'); ?></li>
        </ul>

        <h4 id="Messaging" class="side-navigation-header side-navigation-divider">
            <a href="#">Messaging</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Html->link('Notifications', '/notification/index'); ?></li>
            <li><?php echo $this->Html->link(' - Create', '/notification/create'); ?></li>
            <li><?php echo $this->Html->link('Invite a Friend', '/people/invite'); ?></li>
        </ul>

        <h4 id="System" class="side-navigation-header">
            <a href="#">System</a>
            <span class="side-navigation-toggle">&#9660;</span>
        </h4>
        <ul class="side-navigation">
            <li><?php echo $this->Html->link('Users', '/admin/users'); ?></li>
            <li><?php echo $this->Html->link('Groups', '/admin/users/acl_groups'); ?></li>
            <li><?php echo $this->Html->link('Picklists', '/admin/picklists/index'); ?></li>
        </ul>

    <?php endif; ?>
<?php endif; ?>
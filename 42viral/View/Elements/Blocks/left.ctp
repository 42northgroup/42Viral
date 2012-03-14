<?php // Limit this navigation to admin actions, viewble by only logged in employees ?>
<?php 
    //get the actions prefx if it exists
    $prefix = null;
    if(isset($this->request->params['prefix'])):
        $prefix = $this->request->params['prefix'];
    endif;
    
    if($prefix == 'admin'): ?>
    <?php if($this->Session->check('Auth.User.id')): ?>
        <?php if($this->Session->read('Auth.User.employee') == 1): ?>
            <h4 id="Menu" class="side-navigation-header side-navigation-divider">
                Menu
                <span class="side-navigation-toggle">&#9660;</span>
            </h4>
            <ul class="side-navigation">
                <li><a href="/blogs">Blogs</a></li>
                <li><a href="/members">Members</a></li>
                <li><a href="/pages">Pages</a></li>
            </ul>
            <h4 id="CMS" class="side-navigation-header side-navigation-divider">
                CMS
                <span class="side-navigation-toggle">&#9660;</span>
            </h4>
            <ul class="side-navigation">
                <li>
                    <?php
                    echo $this->Html->link('Create a web page', '/admin/pages/create/');
                    ?>
                </li>
            </ul>

            <h4 id="CRM" class="side-navigation-header">
                CRM
                <span class="side-navigation-toggle">&#9660;</span>
            </h4>
            <ul class="side-navigation">
                <li><?php echo $this->Html->link('People', '/admin/people/'); ?></li>
            </ul>

            <h4 id="Messaging" class="side-navigation-header side-navigation-divider">
                Messaging
                <span class="side-navigation-toggle">&#9660;</span>
            </h4>
            <ul class="side-navigation">
                <li><?php echo $this->Html->link('Notifications', '/notification/index'); ?></li>
                <li><?php echo $this->Html->link(' - Create', '/notification/create'); ?></li>
                <li><?php echo $this->Html->link('Invite a Friend', '/people/invite'); ?></li>
            </ul>

            <h4 id="System" class="side-navigation-header">
                System
                <span class="side-navigation-toggle">&#9660;</span>
            </h4>
            <ul class="side-navigation">
                <li><?php echo $this->Html->link('Users', '/admin/users'); ?></li>
                <li><?php echo $this->Html->link('Groups', '/admin/users/acl_groups'); ?></li>
                <li><?php echo $this->Html->link('Picklists', '/admin/picklists/index'); ?></li>
                <li><?php echo $this->Html->link('Plugins', '/admin/plugin_configuration/configurations'); ?></li>
            </ul>

        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <?php if(isset($userProfile)): ?>
        <div class="avatar">
            <?php echo $this->Member->avatar($userProfile['Person']) ?>
        </div>
    <?php endif; ?>        
    <ul class="side-navigation" style="display:block; padding:6px 0 0;">
        <li><a href="/blogs">Blogs</a></li>
        <li><a href="/members">Members</a></li>
        <li><a href="/pages">Pages</a></li>
    </ul>
    <?php if($this->Session->check('Auth.User.id')): ?>
        <?php if($this->Session->read('Auth.User.employee') == 1): ?>
            <ul class="side-navigation" style="display:block; padding:6px 0 0;">
                <li><a href="/admin">Admin</a></li>
            </ul>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
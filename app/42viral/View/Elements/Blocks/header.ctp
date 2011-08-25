<div id="Header">

    <div id="HeaderLeft">
        <?php if($this->Session->check('Auth.User.id')): ?>
            <?php echo $this->Html->link('CMS', '/contents/content'); ?>
            <?php 
                $googleAppsDomain = Configure::read('Google.Apps.domain');
                if(isset($googleAppsDomain)):
                    echo ' | ';
                    echo $this->Html->link('Google Apps', 'https://www.google.com/a/' . Configure::read('Google.Apps.domain')); 
                endif;
            ?>
        <?php endif; ?>
    </div>

    <div id="HeaderContent"></div>

    <div id="HeaderRight">
        <?php if($this->Session->check('Auth.User.id')): ?>
            <?php echo $this->Html->link('My Account', $this->Session->read('Auth.User.private_url')); ?>
            <?php echo " | "; ?>
            <?php echo $this->Html->link('Logout', '/users/logout'); ?>
        <?php else: ?>
            <?php echo $this->Html->link('New Account', '/users/create'); ?>
            <?php echo " | "; ?>        
            <?php echo $this->Html->link('Login', '/users/login'); ?>
        <?php endif; ?>
    </div>

</div>
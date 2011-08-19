<div id="Header">

    <div id="HeaderLeft">
        <?php if($this->Session->check('Auth.User.User.id')): ?>
            <?php echo $this->Html->link('CMS', '/Contents/content'); ?>
        <?php endif; ?>
        al;skdfj;alskfjd
    </div>

    <div id="HeaderContent"></div>

    <div id="HeaderRight">
        <?php if($this->Session->check('Auth.User.User.id')): ?>
            <?php echo $this->Html->link('My Account', $this->Session->read('Auth.User.User.private_url')); ?>
            <?php echo " | "; ?>
            <?php echo $this->Html->link('Logout', '/users/logout'); ?>
        <?php else: ?>
            <?php echo $this->Html->link('New Account', '/users/create'); ?>
            <?php echo " | "; ?>        
            <?php echo $this->Html->link('Login', '/users/login'); ?>
        <?php endif; ?>
    </div>

</div>
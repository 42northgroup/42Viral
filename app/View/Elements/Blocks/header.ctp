<div id="Header" class="clearfix">

    <div id="HeaderLeft"></div>

    <div id="HeaderContent">The 42Viral Project</div>

    <div id="HeaderRight">
        <?php if($this->Session->check('Auth.User.User.id')): ?>
            <?php echo $this->Html->link('My Account', $this->Session->read('Auth.User.User.private_url')); ?>
            <?php echo " | "; ?>
            <a class="header-right" href="/users/logout">Logout</a>
        <?php else: ?>
            <a class="header-right" href="/users/login">Login</a>
        <?php endif; ?>
    </div>

</div>
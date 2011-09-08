<?php if(isset($userProfile['Person'])): ?>
<div class="profile-navigation">
    <?php echo $this->Html->link('Profile', $userProfile['Person']['url']); ?>
    <?php echo $this->Html->link('Content', "/contents/content/{$userProfile['Person']['username']}"); ?>
    <?php echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}"); ?>
    <?php echo $this->Html->link('Companies', "/companies/index/{$userProfile['Person']['username']}"); ?>
</div>
<?php endif; ?>

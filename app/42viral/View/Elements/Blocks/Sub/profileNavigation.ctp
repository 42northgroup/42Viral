<div class="profile-navigation">
<?php if(isset($userProfile['Person'])): ?>

    <?php echo $this->Html->link('Profile', $userProfile['Person']['url']); ?>

    <?php echo $this->Html->link('Content', "/contents/content/{$userProfile['Person']['username']}"); ?>

    <?php echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}"); ?>

<?php endif; ?>
</div>

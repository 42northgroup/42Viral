<?php //debug($overall_progress); ?>

<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'')); ?>

<?php if($overall_progress['user'] == 100): ?>
    <h2 style="text-decoration: line-through;">
        1. User Profile
    </h2>
<?php else: ?>
    <h2>
        1. <a href="/profiles/edit/<?php echo $user['Profile']['id']; ?>">User Profile</a>
    </h2>
<?php endif; ?>

<?php if($overall_progress['company'] == 100): ?>
    <h2 style="text-decoration: line-through;">
        2. Company Profile
    </h2>
<?php else: ?>
    <h2>
        2. <a href="/companies/create">Company Profile</a>
    </h2>
<?php endif; ?>

<?php if($overall_progress['connect'] == 100): ?>
    <h2 style="text-decoration: line-through;">
        3. Connect
    </h2>
<?php else: ?>
    <h2>
        3. <a href="/oauth/connect">Connect</a>
    </h2>
<?php endif; ?>


<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="sixteen columns alpha omega">

    <?php if($overall_progress['user'] == 100): ?>
        <h2 style="text-decoration: line-through;">
            1. User Profile
        </h2>
    <?php else: ?>
        <h2>
            1. <a href="/profiles/edit/<?php echo $user['Profile']['id']; ?>">User Profile</a>
        </h2>
    <?php endif; ?>


    <?php if($overall_progress['connect'] == 100): ?>
        <h2 style="text-decoration: line-through;">
            2. Connect
        </h2>
    <?php else: ?>
        <h2>
            2. <a href="/oauth/connect">Connect</a>
        </h2>
    <?php endif; ?>
    </div>
</div>


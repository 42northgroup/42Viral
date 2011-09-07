<?php //debug($user); ?>

<div class="clearfix">
    
    <h1 style="float:left;"><?php echo $this->Member->displayName($user['User']) ?>'s Profile</h1>
    
    <div style="float:right; margin:6px 0 0;">
        <?php if($mine): ?>
            <a href="/profiles/edit/<?php echo $user['Profile']['id']; ?>">Edit Profile</a>
        <?php endif; ?>
    </div>
    
</div>

<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<div class="section-box">
    <p>
        <?php echo $user['Profile']['bio']; ?>
    </p>
</div>

<div class="section-box">
    
    <h2>Social Media Stream</h2>
    <?php foreach ($statuses as $status): ?>
        <?php if($status['post'] != ''): ?>

        <p>
            <?php echo $status['post'].'<br/>'; ?>
            <?php 
            switch($status['source']){
                case 'facebook':
                    echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/facebook_16.png');
                    break;

                case 'linkedin':
                    echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/linkedin_16.png');
                    break;

                case 'twitter':
                    echo $this->Html->image('/img/social_media_icons/social_networking_iconpack/twitter_16.png');
                    break;
            }
            ?>
            <?php echo isset($status['time'])? date('F jS \a\t h:ia', $status['time']):''; ?>
            <hr/>
        </p>


        <?php endif; ?>
    <?php endforeach;?>            

</div>

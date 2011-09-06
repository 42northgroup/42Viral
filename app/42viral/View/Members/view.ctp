<?php //debug($user); ?>

<h1><?php echo $this->Member->displayName($user['User']) ?></h1>

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



<?php if($mine): ?>
    <div>
        <a href="/profiles/edit/<?php echo $user['Profile']['id']; ?>">Edit Profile</a>
    </div>
<?php endif; ?>

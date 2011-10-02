<div style="padding:4px 0 0;"><?php echo $user['Profile']['tease']; ?></div>

<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'members')); ?>

<div id="ResultsPage">
    
    <h2>Social Media Stream</h2>
    
    <?php 
    if( isset($statuses['connection']) ):
        foreach($statuses['connection'] as $key => $val):
            echo $key.' does not seem to be responding, please try again later.<br/>';
        endforeach;
    endif; 
    ?>
    
    <?php foreach ($statuses['posts'] as $status): ?>
    
        <?php if($status['post'] != ''): ?>
        <div class="clearfix status">
            <div style="float:left; width: 40px;">
            <?php 
                echo $this->Html->image(
                        "/img/social_media_icons/social_networking_iconpack/{$status['source']}_32.png"); 
            ?>
            </div>
            <div style="float:left; width: 510px;">
                <?php echo $this->Html->div(null, $status['post']); ?>
                <div class="status-details">
                    <?php echo isset($status['time'])? date('F jS \a\t h:ia', $status['time']):''; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    
    <?php endforeach;?>            

</div>

<div class="h1shim"></div>
<div class="row">
    
    <div class="two-thirds column alpha">
        <div id="ResultsPage">
            <h2><?php echo $this->Member->name($userProfile['Person']); ?>'s Content</h2>
            
            <?php foreach($userProfile['Content'] as $content):?>
            <div class="result">
                <div class="clearfix">
                    <h2 style="float:left;"><?php echo $this->Html->link($content['title'], $content['url']); ?> </h2>
                    <div style="float:right; font-style: italic;">
                        <?php echo Inflector::humanize($content['object_type']); ?></div>
                </div>
                <div class="tease"><?php echo $this->Text->truncate($content['title'], 180); ?></div>
            </div>
            <?php endforeach; ?>
            
            <h2>Social Media Stream</h2>

            <?php 
            if( isset($statuses['connection']) ):
                foreach($statuses['connection'] as $key => $val):
                    echo $key . __(' does not seem to be responding, please try again later.') . '<br/>';
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
    </div>
    
    <div class="one-third column omega">
        
        <?php 
            echo $this->element(
                    'Blocks' . DS . 'hcard', 
                    array(
                            'userProfile'=>$userProfile, 
                            'allOpen'=>true,
                            'h1'=>true
                        )
                    ); 
            

        
            //Privides navigation for manageing an asset
            if($mine):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text'=>"Edit Profile",
                        'url'=>"/profiles/edit/{$profileId}",
                        'options' => array(),
                        'confirm'=>null
                    )               
                );
                        
                echo $this->element('Navigation' . DS . 'manage', 
                            array('section'=>'profile', 
                                'additional'=>$additional
                            )
                        );
            endif; 
        ?>

    </div>
    
</div>
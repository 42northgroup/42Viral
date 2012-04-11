<h1><?php echo $title_for_layout; ?></h1>
<div class="rows">
    <div class="one-third column alpha">
        <h2>Installed Plugins</h2>
        <?php foreach($plugins as $plugin):?>
            <div>
                <?php 
                    if(isset($plugin['url'])):
                        echo $this->Html->link($plugin['label'], $plugin['url']); 
                    else:
                       echo $plugin['label'];   
                    endif;
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="one-third column">
        <div><?php echo $this->Html->link('Post Configuration', '/admin/configurations/post_configuration'); ?></div>
    </div>
    <div class="one-third column omega"></div>
</div>
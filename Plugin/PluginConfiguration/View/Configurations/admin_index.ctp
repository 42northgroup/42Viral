<h1>Installed Plugins</h1>

<div id="ResultsPage">    
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
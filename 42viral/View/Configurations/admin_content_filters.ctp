<h1>Content Filters Plugin</h1>
<div class="rows">
    <div class="two-thirds column alpha">
        <?php 
            echo $this->Form->create(null, 
                    array(
                        'class'=>'responsive', 
                        'url'=>$this->here));
            
            echo $this->Form->inputs(array(
                    'legend'=>'Antispam Service',
                    'ContentFiltersAntispamService.id'=>array(
                        'value'=>'ContentFilters.AntispamService', 'type'=>'hidden'),

                    'ContentFiltersAntispamService.value'=>array(
                        'options'=>Configure::read('Picklist.ContentFilter.AntispamServices'), 
                        'label'=>'Antispam Service'),
                ));

            echo $this->Form->inputs(array(
                    'legend'=>'Akismet Key',
                    'ContentFiltersAkismetkey.id'=>array('value'=>'ContentFilters.Akismet.key', 'type'=>'hidden'),

                    'ContentFiltersAkismetkey.value'=>array('label'=>'Akismet Key'),
                ));   

            echo $this->Form->submit();
            
            echo $this->Form->end();

            $servers = array(
                array('server'=> 'rest.akismet.com', 'port'=>'80')
            );
        ?>
    </div>
    
    <div class="one-third column omega">
        <h2>Service Status</h2>
        <table>
            <tr>
                <th>Server/Service</th>
                <th>Status</th>
            </tr>
            <?php foreach($servers as $server): ?>
            <tr>
                <td><?php echo $server['server']; ?></td>
                <td><?php echo Utility::connectionTest($server['server'], 
                                $server['port'])?'Connected :)':'Could not connect :('; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
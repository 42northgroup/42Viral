<style type="text/css">
    label{
        display: block;
    }
    
    input[type='text']{
        width: 98%;
    }
</style>

<?php 
echo $this->Form->create(null, array('url'=>$this->here));

foreach($xmlData['root']['groups'] as $groups):
    
    foreach($groups as $group): 
        echo '<div style="margin:24px 0 0; background: #efefef; padding:12px 8px; border-radius: 4px;">';
        foreach($group as $setting): 
            if(count($setting) > 1):
                echo $this->Form->input(
                        $setting['setting'], 
                        array(
                            //'name'=>"data[{$setting['setting']}]", 
                            'label'=>$setting['setting'], 
                            'value'=>$setting['value'],
                            'type'=>'text'
                            )
                        );
            else:
                echo $this->Form->input(
                        $group['setting'], 
                        array(
                            //'name'=>"data[{$setting['setting']}]", 
                            'label'=>$group['setting'], 
                            'value'=>$group['value'],
                            'type'=>'text'
                            )
                        );
                BREAK;
            endif;
        endforeach;
        echo '</div>';
    endforeach;
endforeach;

echo $this->Form->submit('Configure', 
        array(
            'before'=>
            $this->Html->link('Regen Keys', '/setup/xml_core/regen:1', 
                    array('style'=> 'margin-right: 16px'), 'Are you sure? This will rewrite your configuration!')
            . $this->Html->link('Build Configuration Files', '/setup/process', 
                    array('style'=> 'margin-right: 16px'), 'Are you sure? No new changes will be saved!')));

echo $this->Form->end();
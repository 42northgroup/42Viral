<?php
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
<?php
foreach($xmlData['root']['groups'] as $groups):
    
    foreach($groups as $group): 
        echo '<div style="margin:24px 0 0; background: #efefef; padding:12px 8px; border-radius: 4px;">';
        foreach($group as $setting): 

                
                $fieldName = Inflector::camelize(str_replace('.', ' ', $setting['setting']));
            
                echo $this->Form->input(
                        $fieldName, 
                        array(
                            'name'=>"data[{$setting['setting']}][keyValue]", 
                            'label'=>$setting['setting'], 
                            'value'=>$setting['value'],
                            'type'=>'text'
                            )
                        );
                            
                echo $this->Form->input(
                        $fieldName, 
                        array(
                            'name'=>"data[{$setting['setting']}][default]", 
                            'label'=>$setting['setting'], 
                            'value'=>'?',
                            'type'=>'text'
                            )
                        );                            
                            
                echo $this->Form->input(
                        $fieldName, 
                        array(
                            'name'=>"data[{$setting['setting']}][help]", 
                            'label'=>$setting['setting'], 
                            'value'=>'test',
                            'type'=>'text'
                            )
                        );
        endforeach;
        echo '</div>';
    endforeach;
endforeach;
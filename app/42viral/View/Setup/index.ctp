<style type="text/css">
    label{
        display: block;
    }
    
    input[type='text']{
        width: 98%;
    }
</style>

<?php 
foreach($xmlData['root']['groups'] as $groups):
    foreach($groups as $group):
        echo '<div style="margin:24px 0 0; background: #efefef; padding:12px 8px;">';
        foreach($group as $setting):
                echo $this->Form->input(
                        $setting['setting'], 
                        array(
                            'name'=>$setting['setting'], 
                            'label'=>$setting['setting'], 
                            'value'=>$setting['value'],
                            'type'=>'text'
                            )
                        );
        endforeach;
        echo '</div>';
    endforeach;
endforeach; 
?>



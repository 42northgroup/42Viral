<?php
foreach($xmlData['root'] as $key => $value):
    
    //Parse the $key to identify a grouping change. If the group has changed add some white space.
    $switch = false;
    if(!isset($group)){
        $chunks = explode('.', $key);
        if(count($chunks)==1):
            $group = $chunks[0];
        else:
            unset($chunks[count($chunks)-1]);
            $group = implode('.', $chunks);
        endif;
    }

    if(isset($group)){
        $currentChunks = explode('.', $key);
        if(count($currentChunks)==1):
            $currentGroup = $currentChunks[0];
        else:
            unset($currentChunks[count($currentChunks)-1]);
            $currentGroup = implode('.', $currentChunks);
        endif;

        if($currentGroup != $group){
            $switch = true;
            $group = $currentGroup;
        }
    }


    echo ($switch)?'<br><br>':''; 

    $fieldName = Inflector::camelize(str_replace('.', ' ', $value['name']));

    echo $this->Form->input(
            $fieldName . 'Value', 
            array(
                'name'=>"data[{$value['name']}][value]", 
                'label'=>$value['name'], 
                'value'=>$value['value'],
                'type'=>'text',
                'between'=>$value['help']
                )
            );

?>
<div style="display:none;">
<?php
    echo $this->Form->input(
            $fieldName . 'Name', 
            array(
                'name'=>"data[{$value['name']}][name]", 
                'label'=>$value['name'] . 'name', 
                'value'=>$value['name'],
                'type'=>'text'
                )
            );  

    echo $this->Form->input(
            $fieldName . 'Default', 
            array(
                'name'=>"data[{$value['name']}][default]", 
                'label'=>$value['name'] . 'default', 
                'value'=>$value['default'],
                'type'=>'text'
                )
            );                            

    echo $this->Form->input(
            $fieldName . 'Help', 
            array(
                'name'=>"data[{$value['name']}][help]", 
                'label'=>$value['name'] . 'help', 
                'value'=>$value['help'],
                'type'=>'text'
                )
            );
?>
</div>
<?php    
endforeach;
echo ($switch)?'<br><br>':''; 
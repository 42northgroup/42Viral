<style type="text/css">
    .form-help{
        border: 1px solid #f0f0f0;
        background: #fff;
        padding: 3px;
        margin: 0 4px 0 1px;
        border-radius: 3px;
    }
    
    .form-box{
        padding:8px;
        margin:0 0 8px;
        background: #e2e2e2;
        border-radius: 4px;
    }
</style>    

<?php
$x=1;
echo '<div class="form-box">';
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


    echo ($switch)?'</div><div class="form-box">':''; 

    $fieldName = Inflector::camelize(str_replace('.', ' ', $value['name']));

    echo $this->Form->input(
            $fieldName . 'Value', 
            array(
                'name'=>"data[{$value['name']}][value]", 
                'label'=>$value['name'], 
                'value'=>$value['value'],
                'type'=>'textarea',
                'style'=>'width: 99%;',
                'rows'=>3,
                'between'=>$this->Html->div('form-help', $value['help'])
                . $this->Html->div('form-help', 
                    '<b>Default: ' . $value['default'] . '</b>', 
                    array('style'=>'margin:4px 0 0;'))
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
    echo (count($xmlData['root']) == $x++)?'</div>':''; 
endforeach;
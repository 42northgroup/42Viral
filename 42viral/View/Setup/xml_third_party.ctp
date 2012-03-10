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

echo $this->element('Setup' . DS . 'xml_form', array('xmlData'=>$xmlData)); 

echo $this->Form->submit('Save Configuration', 
        array('before'=>$this->Form->input('Control.next_step', 
                array(
                    'type'=>'checkbox', 
                    'div'=>false, 
                    'style'=>'margin-right: 6px;',
                    'checked'=>true,
                    'label'=>array('style'=>'display:inline; margin-right: 6px;')))));


echo $this->Form->end();
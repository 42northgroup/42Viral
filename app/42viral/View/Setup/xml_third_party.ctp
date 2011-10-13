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
        array(
            'before'=>
            $this->Html->link('Build Configuration Files', '/setup/process', 
                    array('style'=> 'margin-right: 16px'), 'Are you sure? No new changes will be saved!')));

echo $this->Form->end();
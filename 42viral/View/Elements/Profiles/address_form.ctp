<style type="text/css">
    #addressForm{
        display: none;
    }
</style>
<div id="addressForm" class="popUpForm address">
    <?php
    echo $this->Form->create('Address', array(
        'url' => '/profiles/save_person_address',
        'action' => 'save',
        'class' => 'responsive',
        'id' => 'form_address',
        'style' => 'width:290px;'
    ));
    echo $this->Form->input('model_id', array(
        'type' => 'hidden',
        'value' => $userProfile['Person']['id']
    ));
    
    echo $this->Form->input('model', array(
        'type' => 'hidden',
        'value' => 'Person'
    ));

    echo $this->Form->input('type', array(
        'label' => 'Label',
        'type' => 'text'
    ));
    
    echo $this->Form->input('line1', array(
        'label' => 'Street'
    ));
        
    echo $this->Form->input('line2', array(
        'label' => 'apt#, bld# etc.'
    ));
    
    echo $this->Form->input('city');
    echo $this->Form->input('state');
    echo $this->Form->input('zip');
    echo $this->Form->input('country');

    echo $this->Form->submit();
    echo $this->Form->end();
    ?>
</div>
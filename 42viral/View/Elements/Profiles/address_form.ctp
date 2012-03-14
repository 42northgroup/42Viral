<style type="text/css">
    #addressForm{
        z-index: 1000000;
        padding: 10px;
        border: 1px solid black;
        background-color: white;
        border-radius: 10px;
        position: absolute;
        top: 200px;
        left: 350px;
        display: none;
        width: 300px;
    }
</style>
<div id="addressForm" class="popUpForm">
    <?php
    echo $this->Form->create('Address', array(
        'url' => '/profiles/save_person_address',
        'action' => 'save',
        'class' => 'content',
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
        'label' => 'Category',
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
<style type="text/css">
    #personDetailsForm{
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
<div id="personDetailsForm" class="popUpForm" >
    <?php
    echo $this->Form->create('PersonDetail', array(
        'url' => '/profiles/save_person_details',
        'action' => 'save',
        'class' => 'content',
        'style' => 'width:290px;'
    ));
    echo $this->Form->input('person_id', array(
        'type' => 'hidden',
        'value' => $userProfile['Person']['id']
    ));

    echo $this->Form->input('type', array(
        'options' => $types,
        'empty' => true
    ));
    echo $this->Form->input('category');
    echo $this->Form->input('value', array(
        'label' => 'Entry'
    ));

    echo $this->Form->submit();
    echo $this->Form->end();
    ?>
</div>
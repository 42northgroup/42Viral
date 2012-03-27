<style type="text/css">
    #personDetailsForm{
        display: none;
    }
</style>
<div id="personDetailsForm" class="popUpForm <?php echo $type ?>" >
    <?php
    echo $this->Form->create('PersonDetail', array(
        'url' => '/profiles/save_person_details',
        'action' => 'save',
        'class' => 'responsive',
        'id' => 'form_'.$type,
        'style' => 'width:290px;'
    ));
    echo $this->Form->input('person_id', array(
        'type' => 'hidden',
        'value' => $userProfile['Person']['id']
    ));

    echo $this->Form->input('type', array(
        'options' => $types,
        'empty' => true,
        'value' => $type
    ));
    echo $this->Form->input('category', array(
        'label' => 'Label'
    ));
    echo $this->Form->input('value', array(
        'label' => 'Entry'
    ));

    echo $this->Form->submit();
    echo $this->Form->end();
    ?>
</div>
<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2011, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * @author Jason D Snider <jason.snider@42viral.org>
 * @author Zubin Khavarian <zubin.khavarian@42viral.org>
 * @author Lyubomir R Dimov <lrdimov@yahoo.com>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'')); 

$this->Asset->addAssets(array(
    'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
    'vendors' . DS . 'ckeditor' . DS . 'ckeditor.js',
    'vendors' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
), 'ck_editor');

echo $this->Asset->buildAssets('js', 'ck_editor', false);
?>
<script type="text/javascript">
    $(function(){
        var mouse_is_inside = false;

        $("#personDetailsLinks").delegate('.personDetailsLink', 'click', function(event){            
            event.preventDefault();
            $("#personDetailsForm").show();
            $("#PersonDetailType").val($(this).attr('id'));
        });
        
        $('#addressLink').click(function(event){            
            event.preventDefault();
            $("#addressForm").show();
        });
        
        $("#additionalDetailsHolder").delegate('.additionalDetailsType', 'click', function(){            
            var type = $(this).attr('data-type');
            $("#details_" + type).toggle();
        });        
        
        $("#additionalDetailsHolder").delegate('.editDetail', 'click', function(){
            var element = $(this).parent();
            $("#PersonDetailId").val(element.attr('id'))
            $("#PersonDetailValue").val(element.attr('data-value'))
            $("#PersonDetailType").val(element.attr('data-type'))
            $("#PersonDetailCategory").val(element.attr('data-category'))
            $("#personDetailsForm").show();
        });
        
        $('.popUpForm').hover(function(){ 
            mouse_is_inside=true; 
        }, function(){ 
            mouse_is_inside=false; 
        });

        $("body").mouseup(function(){ 
            if(! mouse_is_inside) $('.popUpForm').hide();
        });

    });
</script>
<style>
    .div-header{
        width: 244px; 
        height: 20px; 
        border-bottom: 1px solid black; 
        background-color: #EEE; 
        font-weight: bold; 
        padding: 3px;
    }
</style>
<div style="float: left; width: 500px;" >
    <div style=" margin-bottom: 5px;" id="personDetailsLinks" >
        <a href="#" id="addressLink" >Add Address</a>
        <a href="#" class="personDetailsLink" id="email" style="margin-left: 5px;" >Add Email</a>
        <a href="#" class="personDetailsLink" id="phone" style="margin-left: 5px;" >Add Phone</a>
    </div>
    <?
    echo $this->Form->create('Profile', array(
        'action' => 'save',
        'class'=>'content'
    ));

    echo $this->Form->input('id');

    echo $this->Form->input('owner_person_id', array('type'=>'hidden', 'value'=>$this->Session->read('Auth.User.id')));

    echo $this->Form->input('Person.id', array('value'=>$this->Session->read('Auth.User.id')));
    echo $this->Form->input('Person.first_name');
    echo $this->Form->input('Person.last_name');
    echo $this->Form->input('tease', array('type' => 'textarea', 'rows'=>2));
    echo $this->Form->input('bio', array('class' => 'edit-basic'));

    echo $this->Form->submit('Submit');

    echo $this->Form->end();

    echo $this->element('Profiles/person_details_form');
    echo $this->element('Profiles/address_form');
    ?>
</div>
<div style="float: right" id="additionalDetailsHolder">
    <div style=" border: 1px solid black; width: 250px;" >
        <div class="div-header" >
            Additional Details
        </div>
        <?php foreach($types as $key => $value): ?>
        <div id="type_<?php echo $key ?>" class="additionalDetailFrame" style=" padding: 5px;">
            <a href="#" data-type="<?php echo $key ?>" class="additionalDetailsType" >
                <?php echo $value ?>s
            </a>

            <div style="display: none" id="details_<?php echo $key ?>" >
                <ul style=" margin-left: 0px;">
                <?php foreach($person_details as $detail): ?>
                    <?php if($detail['PersonDetail']['type'] == $key): ?>
                    
                    <li id="<?php echo $detail['PersonDetail']['id'] ?>" 
                        class="additionalDetail"
                        data-type="<?php echo $key ?>" 
                        data-value="<?php echo $detail['PersonDetail']['value']; ?>"
                        data-category="<?php echo $detail['PersonDetail']['category']; ?>" >
                        
                        <?php echo $detail['PersonDetail']['category'].': '.$detail['PersonDetail']['value']; ?>
                        <a href="#" style="float: right; margin-left:5px; " >X</a>
                        <a href="#" style=" float: right" class="editDetail">Edit</a>                        
                    </li>
                    
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
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
        
        $("#additionalDetailsHolder").delegate('.editDetail', 'click', function(event){
            event.preventDefault();
            var element = $(this).parent();
            $("#PersonDetailId").val(element.attr('id'));
            $("#PersonDetailValue").val(element.attr('data-value'));
            $("#PersonDetailType").val(element.attr('data-type'));
            $("#PersonDetailCategory").val(element.attr('data-category'));
            $("#personDetailsForm").show();
        });
        
        $("#additionalDetailsHolder").delegate('.editAddress', 'click', function(event){
            event.preventDefault();
            var element = $(this).parent();
            $("#AddressId").val(element.attr('id'));
            $("#AddressLine1").val(element.attr('data-line1'));
            $("#AddressLine2").val(element.attr('data-line2'));
            $("#AddressCity").val(element.attr('data-city'));
            $("#AddressState").val(element.attr('data-state'));
            $("#AddressZip").val(element.attr('data-zip'));
            $("#AddressCountry").val(element.attr('data-country'));
            $("#AddressType").val(element.attr('data-type'));
            $("#addressForm").show();
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

<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <?
        echo $this->Form->create('Profile', array(
            'action' => 'save',
            'class'=>'responsive'
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
        ?>
    </div>
    
    <div class="one-third column omega">
        <div id="additionalDetailsHolder" class="column-block">
            <h4>Additional Details</h4>
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
                                <a href="/profiles/delete_person_detail/<?php echo $detail['PersonDetail']['id'] ?>" 
                                style="float: right; margin-left:5px;" >
                                    X
                                </a>
                                <a href="#" style=" float: right" class="editDetail">Edit</a>                        
                            </li>

                            <?php endif; ?>
                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
                
                <div id="type_address" class="additionalDetailFrame">
                    <a href="#" data-type="address" class="additionalDetailsType" >
                        Addresses
                    </a>

                    <div style="display: none" id="details_address" >
                        <ul style=" margin-left: 0px;">
                        <?php foreach($addresses as $address): ?>

                            <li id="<?php echo $address['Address']['id'] ?>" 
                                class="additionalDetail"
                                data-type="<?php echo $address['Address']['type'] ?>" 
                                data-line1="<?php echo $address['Address']['line1']; ?>"
                                data-line2="<?php echo $address['Address']['line2']; ?>"
                                data-city="<?php echo $address['Address']['city']; ?>"
                                data-state="<?php echo $address['Address']['state']; ?>"
                                data-zip="<?php echo $address['Address']['zip']; ?>"
                                data-country="<?php echo $address['Address']['country']; ?>">

                                <?php echo $address['Address']['type']; ?>
                                <a href="/profiles/delete_person_address/<?php echo $address['Address']['id'] ?>" 
                                style="float: right; margin-left:5px;" >
                                    X
                                </a>
                                <a href="#" style=" float: right" class="editAddress">Edit</a>                        
                            </li>                    

                        <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        
            <div class="column-block">
                <div id="personDetailsLinks" >
                    <a href="#" id="addressLink" >Add Address</a>
                    <a href="#" class="personDetailsLink" id="email" style="margin-left: 5px;" >Add Email</a>
                    <a href="#" class="personDetailsLink" id="phone" style="margin-left: 5px;" >Add Phone</a>
                </div>
            </div>

            <div class="column-block">
            <?php
                echo $this->element('Profiles/person_details_form');
                echo $this->element('Profiles/address_form');
            ?>   
            </div>
        
        </div>
</div>
    


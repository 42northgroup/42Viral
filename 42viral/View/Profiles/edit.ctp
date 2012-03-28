<?php
App::uses('Handy', 'Lib');
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
        
        $("#additionalDetailsHolder").delegate('.personDetailsLink', 'click', function(event){            
            event.preventDefault();
            
            var element = $(this);
            
            $("#form_"+element.attr('id')).clearForm();
            
            $('.' + element.attr('id')).toggle();
            
            $("#PersonDetailType").val(element.attr('id'));
            
            if($.trim(element.text()) == "+"){
                element.text("-")
            }else{
                element.text("+")
            }
        });
        
        
        /*
        $("#additionalDetailsHolder").delegate('.additionalDetailsType', 'click', function(){            
            var type = $(this).attr('data-type');
            $("#details_" + type).toggle();
        });        
        */
        $("#additionalDetailsHolder").delegate('.editDetail', 'click', function(event){
            event.preventDefault();
            var element = $(this).parent();
            var formClass = $(this).attr('id').replace('edit_', '');
            
            $("#form_" + formClass + " input[id=PersonDetailType]").val(element.attr('data-type'));
            $("#form_" + formClass + " input[id=PersonDetailId]").val(element.attr('id'));
            $("#form_" + formClass + " input[id=PersonDetailValue]").val(element.attr('data-value'));
            $("#form_" + formClass + " input[id=PersonDetailCategory]").val(element.attr('data-category'));
            $("." + formClass ).toggle();
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
            $("#addressForm").toggle();
        });
        

    });
    
    $.fn.clearForm = function() {
      return this.each(function() {
        var type = this.type, tag = this.tagName.toLowerCase();
        if (tag == 'form')
          return $(':input',this).clearForm();
        if (type == 'text' || type == 'password' || tag == 'textarea')
          this.value = '';
        else if (type == 'checkbox' || type == 'radio')
          this.checked = false;
        else if (tag == 'select')
          this.selectedIndex = -1;
      });
    };


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
    
    .personDetailsLink:link, .personDetailsLink:visited{
        color: #FFF;
    }
    
    div.column-block .personDetailsLink:hover{
        box-shadow: 1px 1px 1px green inset;
        background-color: #FFF;
        border-color: #FFF;
        color: green;
    }
    
    .personDetailsLink{
        background-color: green;
        border: 1px solid green;
        border-radius: 5px 5px 5px 5px;
        box-shadow: 1px 1px 1px #FFFFFF inset;
        color: #FFF;
        font-weight: bold;
        font-size: 13pt;
        cursor: pointer;
        padding: 3px 12px 0px 12px;
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
        
        echo $this->Form->input('tease', array('type' => 'textarea'));
        echo $this->Form->input('bio', array('rows' => 2));

        echo $this->Form->submit('Submit');

        echo $this->Form->end();
        ?>
    </div>
    
    <div class="one-third column omega">
        <div id="additionalDetailsHolder" class="column-block">
            <h4>Additional Details</h4>
            <?php foreach($types as $key => $value): ?>
                <div id="type_<?php echo $key ?>" class="additionalDetailFrame">
                    <h5 class=" clearfix">
                        <?php echo $value ?>
                        <a href="#" style="float:right" class="personDetailsLink" id="<?php echo $key ?>" >
                            +
                        </a>
                    </h5>
                    

                    <div id="details_<?php echo $key ?>" >
                        <div>
                        <?php foreach($person_details as $detail): ?>
                            
                            <?php if($detail['PersonDetail']['type'] == $key): ?>

                            <div id="<?php echo $detail['PersonDetail']['id'] ?>" 
                                class="additionalDetail"
                                data-type="<?php echo $key ?>" 
                                data-value="<?php echo $detail['PersonDetail']['value']; ?>"
                                data-category="<?php echo $detail['PersonDetail']['category']; ?>" >

                                <?php echo "<em>" . $detail['PersonDetail']['category']. '</em>: '; ?> 
                                
                                <?php
                                    switch($key){
                                        case 'email':
                                            echo Handy::email($detail['PersonDetail']['value']);
                                        break;
                                    
                                       case 'phone':
                                            echo Handy::phoneNumber($detail['PersonDetail']['value']);
                                        break;                                    
                                    } 
                                ?>
                                
                                <a href="/profiles/delete_person_detail/<?php echo $detail['PersonDetail']['id'] ?>" 
                                style="float: right; margin-left:5px;" >
                                    X
                                </a>
                                <a href="#" style=" float: right" id="edit_<?php echo $key ?>" class="editDetail">
                                    Edit
                                </a>                        
                            </div>

                            <?php endif; ?>
                            
                        <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <?php echo $this->element('Profiles/person_details_form', array(
                        'type' => $key
                    )); ?>  
                    
                </div>
            <?php endforeach; ?>
                
                <div id="type_address" class="additionalDetailFrame">
                    <h5>
                        Addresses
                        <a href="#" style="float:right" class="personDetailsLink" id="address" >+</a>
                    </h5>
                    
                    <div id="details_address" >
                        <div>
                        <?php foreach($addresses as $address): ?>

                            <div id="<?php echo $address['Address']['id'] ?>" 
                                class="additionalDetail"
                                data-type="<?php echo $address['Address']['type'] ?>" 
                                data-line1="<?php echo $address['Address']['line1']; ?>"
                                data-line2="<?php echo $address['Address']['line2']; ?>"
                                data-city="<?php echo $address['Address']['city']; ?>"
                                data-state="<?php echo $address['Address']['state']; ?>"
                                data-zip="<?php echo $address['Address']['zip']; ?>"
                                data-country="<?php echo $address['Address']['country']; ?>">

                                <a href="/profiles/delete_person_address/<?php echo $address['Address']['id'] ?>" 
                                style="float: right; margin-left:5px;" >
                                    X
                                </a>
                                <a href="#" style=" float: right" class="editAddress">Edit</a>
                                
                                <em><?php echo $address['Address']['type']; ?></em>
                                
                                <div><?php echo $address['Address']['line1']; ?></div>
                                <div><?php echo $address['Address']['line2']; ?></div>
                                <div>
                                    <?php echo $address['Address']['city'] . ", " .$address['Address']['state']; ?>
                                    <?php echo ", " . $address['Address']['country'], ', Earth'; ?>  
                                </div>
                                <div><?php echo $address['Address']['zip']; ?></div>
                                                                       
                            </div>                    

                        <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <?php echo $this->element('Profiles/address_form'); ?>
                </div>
            </div>        

        </div>
</div>
    


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
 * @author Lyubomir R Dimov <lyubomir.dimov@42viral.org>
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>

<script type="text/javascript">
    $(function(){
        
        $('table').delegate('a', 'click', function(e){
            e.preventDefault();
            var range = $(this).attr('id');
                        
            if(range == 'AllControllers'){
                $('input[type=checkbox]').each(function () {
                   var checkbox_id = $(this).attr('id');
                   
                   if($("#"+checkbox_id).prop('checked')==true){
                       $("#"+checkbox_id).prop('checked', false);
                   }else{
                       $("#"+checkbox_id).prop('checked', true);
                   }
                   
                });
            }else{
                $('input[type=checkbox]').each(function () {
                   var checkbox_id = $(this).attr('id');
                   if (checkbox_id.indexOf(range) != -1) {
                        if($("#"+checkbox_id).prop('checked')==true){
                            $("#"+checkbox_id).prop('checked', false);
                        }else{
                            $("#"+checkbox_id).prop('checked', true);
                        }
                   }
                });
            }
            
        });
    });
</script>

<?php
echo $this->element('Navigation' . DS . 'local', array('section'=>'configuration', 'class'=>'config'));
echo $this->Form->create('UserPrivs', array('url'=>'/setup/give_permissions/'.$username)); 
?>

This provides the default set of permissions for a user. The permissions granted here will be automatically applied to 
anyone creating an account. So please, think about this for a few moments before proceeding!

<table>
    <thead>
        <th><a href="" id="AllControllers" >Controller -> action</a></th>
        <th>Create</th>
        <th>Read</th>
        <th>Update</th>
        <th>Delete</th>
    </thead>        
    <tbody>
        <?php foreach($controllers as $key => $val): ?>
            <?php foreach($controllers[$key] as $index => $action): ?>
            <tr>
                <td>
                    <a href="" id="<?php echo $key ?>" ><?php echo $key ?></a>
                    ->
                    <?php $action_id = str_ireplace('_', ' ', $action); ?>
                    <?php $action_id = ucwords($action_id); ?>
                    <?php $action_id = str_ireplace(' ', '', $action_id); ?>
                    <a href="" id="<?php echo $key.$action_id ?>" ><?php echo $action ?></a>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.create", array(
                        'type' => 'checkbox',
                        'label' => false
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.read", array(
                        'type' => 'checkbox',
                        'label' => false
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.update", array(
                        'type' => 'checkbox',
                        'label' => false
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.delete", array(
                        'type' => 'checkbox',
                        'label' => false
                    ))?>
                </td>
            </tr>
            <?php endforeach; ?>        
        <?php endforeach; ?>
            <tr>
                <td colspan="5">
                <?php echo $this->Form->submit('Save Configuration'); ?>
                </td>
            </tr>
    </tbody>
</table>
<?php echo $this->Form->end(); ?>
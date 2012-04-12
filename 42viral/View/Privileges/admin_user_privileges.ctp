<?php
/**
 * PHP 5.3
 *
 * 42Viral(tm) : The 42Viral Project (http://42viral.org)
 * Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2009-2012, 42 North Group Inc. (http://42northgroup.com)
 * @link          http://42viral.org 42Viral(tm)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<h1><?php echo $title_for_layout; ?></h1>
<script type="text/javascript">
    $(function(){
        
        $("#JoinGroup").click(function(event){
            event.preventDefault();
            $("#JoinGroupList").toggle();
        });
        
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
<?php if(!isset($is_group)): ?>

    <a href="" id="JoinGroup">Join Group</a>
    
    <div id="JoinGroupList" style="display: none">
        Groups<br/>
        <?php
        echo $this->Form->create('JoinGroup', array('url'=>'/admin/privileges/join_group'));
        echo $this->Form->input('user_alias', array(
            'type'=>'hidden',
            'value'=>$username
        ));    
        echo $this->Form->input('groups', array(
            'options'=>$acl_groups,
            'empty'=>true,
            'label'=>false,
            'style'=>'float:left'
            ));
        echo $this->Form->submit('Submit', array('style'=>'float:left; margin-left:10px;'));
        echo $this->Form->end();
        ?>
    </div>
    <div style="clear:both"></div>
<?php endif; ?>    

<?php echo $this->Form->create('UserPrivs', array('url'=>'/admin/privileges/user_privileges/'.$username)); ?>

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
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['create']) 
                                    || $privileges[$key][$action]['create'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['create'])?$privileges[$key][$action]['create']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.read", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['read']) 
                                    || $privileges[$key][$action]['read'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['read'])?$privileges[$key][$action]['read']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.update", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['update']) 
                                    || $privileges[$key][$action]['update'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['update'])?$privileges[$key][$action]['update']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.delete", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['delete']) 
                                    || $privileges[$key][$action]['delete'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['delete'])?$privileges[$key][$action]['delete']+2:1
                    ))?>
                </td>
            </tr>
            <?php endforeach; ?>        
        <?php endforeach; ?>
            <tr>
                <td colspan="5" style=" text-align: center; font-weight: bold; font-size: 16pt" >
                    Plugins
                </td>
            </tr>
        <?php foreach($plugins as $key => $val): ?>
            <?php foreach($plugins[$key] as $index => $action): ?>
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
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['create']) 
                                    || $privileges[$key][$action]['create'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['create'])?$privileges[$key][$action]['create']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.read", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['read']) 
                                    || $privileges[$key][$action]['read'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['read'])?$privileges[$key][$action]['read']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.update", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['update']) 
                                    || $privileges[$key][$action]['update'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['update'])?$privileges[$key][$action]['update']+2:1
                    ))?>
                </td>
                <td>
                    <?php echo $this->Form->input("$key.$action.delete", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => (!isset($privileges[$key][$action]['delete']) 
                                    || $privileges[$key][$action]['delete'] == -1)?'':'checked',
                        
                        'value' => isset($privileges[$key][$action]['delete'])?$privileges[$key][$action]['delete']+2:1
                    ))?>
                </td>
            </tr>
            <?php endforeach; ?>        
        <?php endforeach; ?>
            <tr>
                <td colspan="5"><?php echo $this->Form->submit('Submit', array('style'=>'fliat:right')) ?></td>
            </tr>
    </tbody>
</table>
<?php echo $this->Form->end(); ?>
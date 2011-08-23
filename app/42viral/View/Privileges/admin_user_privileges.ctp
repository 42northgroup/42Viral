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
<h1>User Privileges</h1>

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
                <td colspan="5"><?php echo $this->Form->submit('Submit', array('style'=>'fliat:right')) ?></td>
            </tr>
    </tbody>
</table>
<?php echo $this->Form->end(); ?>
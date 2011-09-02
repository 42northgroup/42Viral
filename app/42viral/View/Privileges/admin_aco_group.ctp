<script type="text/javascript">
    $(function(){
             
        $("#AllControllers").click(function(event){
            event.preventDefault();
            
            $('input[type=checkbox]').each(function () {
               var checkbox_id = $(this).attr('id');

               if($("#"+checkbox_id).prop('checked')==true){
                   $("#"+checkbox_id).prop('checked', false);
               }else{
                   $("#"+checkbox_id).prop('checked', true);
               }

            });
        });
        
    });
</script>
<h1>Aco Group</h1>

<?php echo $this->Form->create('GroupChildren', array('url'=>'/admin/privileges/add_to_group/'.$group['Aco']['id'])); ?>

<table>
    <thead>
        <th><a href="" id="AllControllers" >Controller -> action</a></th>        
        <th></th>
    </thead>        
    <tbody>
        <?php foreach($controllers as $key => $val): ?>
            <?php foreach($controllers[$key] as $index => $action): ?>
            <tr>
                <td>
                    <?php echo $key ?>-><?php echo $action ?>
                </td>
               
                <td>
                    <?php echo $this->Form->input("$key.$action", array(
                        'type' => 'checkbox',
                        'label' => false,
                        'checked' => ($acos[$key.'-'.$action] == $group['Aco']['id'])?'checked':''
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
<script type="text/javascript">

    $(function(){

        $("#ContentAjaxFormTrigger").click( function(event){
            event.preventDefault();
            var formId = 'ContentAjaxForm';

            $.ajax({
            	type:'POST',
                url: '/sandboxes/process_ajax_form/',

                //dataType : 'json',
                data : $('#' + formId).serialize(),
                beforeSend: function(){
                    $('#Message').html("Thinking...");
                },

                success: function(response){

                    if(response.ServerError == true){
                    	$('#Message').html("failed");

                    }else{
                    	$('#Message').html("submitted");
                    	console.log(response);
                    }

                    $('#Form').load('/sandboxes/process_ajax_form/');
                }
           });
        })

    });

</script>
<div id="Message"></div>
<?php
echo $this->Form->create(
    'Content',
    array(
        'url'=>'/sandboxes/process_ajax_form/',
        'class'=>'responsive',
        'default'=>false

    )
);
?>
<?php echo $this->Form->input('title'); ?>
<?php echo $this->Form->submit('Submit', array('id'=>'ContentAjaxFormTrigger')); ?>
<?php echo $this->Form->end(); ?>

<?php echo 'the form has been reloaded '; debug($data); ?>
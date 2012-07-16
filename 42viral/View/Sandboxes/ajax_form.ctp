<div id="Form">

    <script type="text/javascript">

        $(function(){

            $("#ContentAjaxFormTrigger").click( function(event){
                event.preventDefault();
                var formId = 'ContentAjaxForm';

                $.ajax({
                    url: '/sandboxes/process_ajax_form/',
                    type:'POST',
                    dataType : 'html',
                    data : $('#' + formId).serialize(),
                    beforeSend: function(){
                        $('#Message').html("Thinking...");
                    },

                    success: function(response){

                        if(response.ServerError === true){
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
            'id'=>'ContentAjaxForm'

        )
    );
    ?>
    <?php echo $this->Form->input('title'); ?>
    <?php echo $this->Form->input('body'); ?>
    <?php echo $this->Form->submit('Submit', array('id'=>'ContentAjaxFormTrigger')); ?>
    <?php echo $this->Form->end(); ?>
</div>
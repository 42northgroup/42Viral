<script type="text/javascript">

    $(function(){

        $("form").delegate('#ContentAjaxFormTrigger', 'click', function(){
           var id = $(this).attr('id');

           $.ajax({
                url: '/sandboxes/process_ajax_form/',

               beforeSend: function(){
                $('#Message').html("Thinking...");

              },

                success: function(response){

                    $('#' + id).removeClass();
                    $('#' + id).next().removeClass();
                    $('#Message').html("submitted");
                    $('#Form').load('/sandboxes/process_ajax_form/');
                }
           });
       })

    });

</script>
<div id="Message"></div>

<div id="Form">
    <?php
    echo $this->Form->create(
        'Content',
        array(
            //'url'=>'/sandboxes/process_ajax_form/',
            'class'=>'responsive',
            'default'=>false

        )
    );
    ?>
    <?php echo $this->Form->input('title'); ?>
    <?php echo $this->Form->submit('Submit', array('id'=>'ContentAjaxFormTrigger')); ?>
    <?php echo $this->Form->end(); ?>
</div>
<?php
    $this->Asset->addAssets(array(
        'vendors/noty/js/jquery.noty.js',
        'vendors/noty/css/jquery.noty.css'
    ), 'noty');

    echo $this->Asset->buildAssets('js', 'noty', false);
    echo $this->Asset->buildAssets('css', 'noty', false);
?>
<script type="text/javascript">
noty(
    {
        "text":"<?php echo $message; ?>",
        "layout":"top",
        "type":"alert",
        "textAlign":"center",
        "easing":"swing",
        "animateOpen":{"height":"toggle"},
        "animateClose":{"height":"toggle"},
        "speed":"500",
        "timeout":"5000",
        "closable":true,
        "closeOnSelfClick":true
    }
);
</script>

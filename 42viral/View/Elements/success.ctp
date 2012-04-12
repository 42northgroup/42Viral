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
        "type":"success",
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
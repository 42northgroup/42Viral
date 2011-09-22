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
?>

<script type="text/javascript">
    $(function() {
        resetCoords();

        var cropBox = $('#cropbox');
        
        cropBox.Jcrop({
            onSelect: showCoords,
            onChange: showCoords,
            minSize: [150, 150],
            setSelect: [0, 0, cropBox.width(), cropBox.height()],

            aspectRatio: 1
        });

        $('#image_delete').click(function(e){
            return confirm('Are you sure?');
        });
    });

    function resetCoords() {
        $('#UploadImageX').val('');
        $('#UploadImageY').val('');

        $('#UploadImageX2').val('');
        $('#UploadImageY2').val('');

        $('#UploadImageW').val('');
        $('#UploadImageH').val('');
    }

    function showCoords(c) {
        //console.log(c);

        $('#UploadImageX').val(c.x);
        $('#UploadImageY').val(c.y);

        $('#UploadImageX2').val(c.x2);
        $('#UploadImageY2').val(c.y2);

        $('#UploadImageW').val(c.w);
        $('#UploadImageH').val(c.h);
    }
</script>

<h1><?php echo $this->Member->displayName($userProfile['Person']); ?>'s Photo Stream</h1>

<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<div style="margin: 8px 0 0; text-align:center;">
    <?php 
        echo $this->Html->image(
            $path,
            array(
                //'style' => 'width: 512px;',
                'id' => 'cropbox'
            )
        );
    ?>
</div>

<div>
    <?php if($mine): ?>
        <?php
        echo $this->Html->link('Set as Avatar',
            "/uploads/set_avatar/{$this->Session->read('Auth.User.id')}/{$image['Image']['id']}"
        );
        ?>
        /
        <?php
        echo $this->Html->link('Use Gravatar Instead',
            "/uploads/use_gravatar/{$this->Session->read('Auth.User.id')}"
        );
        ?>
        /
        <?php
        echo $this->Html->link('Delete',
            "/uploads/delete/{$this->Session->read('Auth.User.id')}/{$image['Image']['id']}",
            array(
                'id' => 'image_delete'
            )
        );
        ?>
    <?php endif; ?>    
</div>

<?php
echo $this->Form->create('Upload', array(
    'action' => 'crop_image'
));
?>

<?php

echo $this->Form->input('image_uuid', array(
    'type' => 'hidden',
    'value' => $image['Image']['id']
));

echo $this->Form->text('image_x', array(
    'type' => 'hidden'
));

echo $this->Form->text('image_y', array(
    'type' => 'hidden'
));

echo $this->Form->text('image_x2', array(
    'type' => 'hidden'
));

echo $this->Form->text('image_y2', array(
    'type' => 'hidden'
));

echo $this->Form->text('image_w', array(
    'type' => 'hidden'
));

echo $this->Form->text('image_h', array(
    'type' => 'hidden'
));

?>


<?php echo $this->Form->submit('Crop'); ?>
<?php echo $this->Form->end(); ?>
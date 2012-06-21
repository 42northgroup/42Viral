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

<?php echo $this->Form->create('Notification',array('url'=>$this->here)); ?>
<?php
    echo $this->Form->input(
        'Control.action',
        array(
            'legend'=>false,
            'type'=>'radio',
            'options'=>$listActionTypes,
            'after'=>$this->Form->submit('Take Action', array('div'=>false))
        )
    );
?>
<table>
    <tbody>
    <?php foreach($notifications as $notification): ?>
        <tr>
            <td>
            <?php
                echo $this->Form->input(
                    $notification['Notification']['id'],
                    array(
                        'div'=>false,
                        'label'=>false,
                        'type'=>'checkbox'
                    )
                );
            ?>
            </td>
            <td>
                <?php echo $this->Html->link(
                    $notification['Notification']['subject'],
                    "/notifications/view/{$notification['Notification']['id']}/"
                ); ?>
                -
                <?php echo $this->Text->truncate(Scrub::noHtml($notification['Notification']['body'])); ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php echo $this->Form->end(); ?>
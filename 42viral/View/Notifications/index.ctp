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
<style type="text/css">
    #ActionButton{
        padding:0;
        margin:0;
        border:0;
        background-color:transparent;
        color:#21759B;
        text-decoration:none;
        font: 13px/1.231 "Droid Sans";
        line-height: 1.6em;
        margin-right: 8px;
    }

    #ActionControlPanel label{
        margin-right: 8px;
    }

    tr.read{
        color: #aaa;
        background: #eee;
    }

</style>
<h1><?php echo $title_for_layout; ?></h1>

<?php echo $this->Form->create('Notification',array('url'=>$this->here)); ?>
<?php
    $boxLinks = '<strong>Go To: </strong> ';
    $x = 0;
    foreach($boxes as $key => $value):
        $boxLinks .= ($x > 0?' | ':null) . $this->Html->link($value, "/notifications/index/{$key}/");
        $x++;
    endforeach;

    echo $this->Form->input(
        'Control.action',
        array(
            'div'=>array('id'=>'ActionControlPanel'),
            'legend'=>false,
            'type'=>'radio',
            'options'=>$listActionTypes,
            'after'=>' ' . $this->Form->submit(__('Perform'), array('id'=>'ActionButton', 'div'=>false)) . $boxLinks
        )
    );
?>
<div class="rows">
    <div class="two-thirds column alpha">
        <table>
            <tbody>
            <?php foreach($notifications as $notification): ?>
                <tr class="<?php echo $notification['Notification']['marked']; ?>">
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
                        <?php
                        echo $this->Html->link(
                            $notification['Notification']['subject'],
                            "/notifications/view/{$notification['Notification']['id']}/"
                        );
                        echo ' - ';
                        echo Scrub::noHtml(
                            $this->Text->truncate(
                                    $notification['Notification']['body'],
                                    '80'
                                )
                            );
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="one-third column alpha"></div>
</div>
<?php echo $this->Form->end(); ?>
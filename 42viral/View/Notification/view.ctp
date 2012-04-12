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

<?php
$additional = array(
    array(
        'text' => "Edit",
        'url' => "/notification/edit/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm' => null
    ),
    array(
        'text' => "Delete",
        'url' => "/notification/delete/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm' => 'Are you sure you want to delete this? \n This action CANNOT be reversed!'
    ),
    array(
        'text' => "Test Fire",
        'url' => "/notification/test/{$notification['Notification']['id']}",
        'options' => array(),
        'confirm' => null
    )
);

echo $this->element('Navigation' . DS . 'local', array('section' => 'notifications', 'additional' => $additional));
?>

<table class="vertical-label-tb">
    <tbody>
        <tr>
            <td>
                Alias
            </td>

            <td>
                <?php  echo $notification['Notification']['alias']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Name
            </td>

            <td>
                <?php  echo $notification['Notification']['name']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Subject Template
            </td>

            <td>
                <?php  echo $notification['Notification']['subject_template']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Body Template
            </td>

            <td>
                <?php  echo $notification['Notification']['body_template']; ?>
            </td>
        </tr>

        <tr>
            <td>
                Active
            </td>

            <td>
                <?php  echo ($notification['Notification']['active'])? 'Yes': 'No'; ?>
            </td>
        </tr>
    </tbody>
</table>
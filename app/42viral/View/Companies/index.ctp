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

/**
 *
 * @author Zubin Khavarian <zubin.khavarian@42viral.com>
 * @author Jason D Snider <jsnider77@gmail.com>
 */
?>

<?php if(isset($userProfile)): ?>
    <h1><?php echo $this->Member->displayName($userProfile['Person']) ?>'s Companies</h1>
    <?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>    
<?php else: ?>
    <h1>Company Index</h1> 
<?php endif; ?>


<table>
    <thead>
        <tr>
            
            <?php echo ($mine)?'<th>Actions</th>':''; //Only show actions if we are viewing "MY" companies ?>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($companies as $tempCompany): ?>
            <tr>
                <?php if($mine): ?>
                <td>
                    <?php echo $this->Html->link('[E]', $tempCompany['edit_url']); ?> /
                    <?php echo $this->Html->link('[D]', $tempCompany['delete_url']); ?>
                </td>
                <?php endif; ?>
                <td>
                    <?php echo $this->Html->link($tempCompany['name'], 
                            $tempCompany['public_url']); ?>
                </td>

                <td>
                    <?php if(isset($tempCompany['Address']) && !empty($tempCompany['Address'])): ?>
                        <table>
                            <?php foreach($tempCompany['Address'] as $tempAddress): ?>
                                <tr>
                                    <td><?php echo $tempAddress['_us_full_address']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </td>

                <td>
                    <?php echo $tempCompany['phone1']; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
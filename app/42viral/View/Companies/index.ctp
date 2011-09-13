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
    
<div id="ResultsPage">
<?php foreach($companies as $company): ?>
    <h2><?php echo $this->Html->link($company['name'], $company['public_url']); ?></h2>
    <?php echo $company['tease']; ?>
<?php endforeach; ?>
</div>


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

<h1><?php echo $this->Member->displayName($userProfile['Person']); ?>'s Photo Stream</h1>

<?php echo $this->element('Blocks' . DS . 'Sub' . DS . 'profileNavigation'); ?>

<div style="margin: 8px 0 0; text-align:center;">
    <?php echo $this->Html->image($path, array('style'=>'width:512px;')) ?>
</div>

<div>
    <?php if($mine): ?>
       <?php echo $this->Html->link('Set Avatar',
               "/uploads/set_avatar/{$this->Session->read('Auth.User.id')}/{$image['Image']['id']}"); ?>
    <?php endif; ?>    
</div>
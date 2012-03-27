 <?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake.libs.view.templates.pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * UI for creating local navigation. Local navigation is defined as navigiation the is local to a specific section of 
 * the web site or a database record.
 * 
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>
<div class="column-block">
    <div class="navigation-block">
        <?php 
            if(isset($userProfile)):

                echo $this->Html->link('Profile', $userProfile['Person']['url']);
                echo $this->Html->link('Content', "/contents/content/{$userProfile['Person']['username']}");
                echo $this->Html->link('Blogs', "/blogs/index/{$userProfile['Person']['username']}");                  
                echo $this->Html->link('Photos', "/uploads/images/{$userProfile['Person']['username']}");
            else:
                echo '&nbsp;';
            endif; 
        ?> 
    </div>
</div>


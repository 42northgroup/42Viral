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
 * UI for the results of tag based searches
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>
<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'Search')); ?>

<div id="ResultsPage">    
    
    
    
    <?php 
    
    foreach($contents as $content): ?>

        <h2>
            <?php echo $this->Html->link($content['Page']['title'], 
                    "/{$content['Page']['object_type']}/{$content['Page']['slug']}"); ?>
        </h2>
    
        <div class="tease"><?php echo $content['Page']['tease']; ?></div>
        
    <?php endforeach; ?>
</div>

<?php
    echo $this->element('paginate');
    
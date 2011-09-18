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
 * @author Jason D Snider <jason.snider@42viral.org>
 */
?>

<div class="clearfix">
    
    <h1 style="float:left;"><?php echo $case['CaseModel']['subject']; ?></h1>
    
    <div style="float:right; margin:6px 0 0;">
        <?php
            echo $this->Html->link('Edit', "/admin/cases/edit/{$case['CaseModel']['id']}");
            echo ' / ';
            echo $this->Html->link('Complete', "/admin/cases/complete/{$case['CaseModel']['id']}");
            echo ' / ';                
            echo $this->Html->link('Delete', "/admin/cases/delete/{$case['CaseModel']['id']}", null,
                    Configure::read('System.purge_warning'));
        ?>
    </div>
    
</div>

<div><?php echo $case['CaseModel']['body']; ?></div>
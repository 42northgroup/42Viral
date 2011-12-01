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

echo $this->element('Navigation' . DS . 'local', array('section'=>'people')); 

?>
<script type="text/javascript">
    $(function(){
        $('tr').delegate('.double-row-controls','mouseleave',function(){
            $(this).addClass('hide-double-row-controls');
        });
    });

    $(function(){
        $('tr').delegate('.double-row-controls','mouseenter',function(){
            $(this).removeClass('hide-double-row-controls');
        });
    });

</script>

<style type="text/css">
    .hide-double-row-controls,
    .hide-double-row-controls a:link,
    .hide-double-row-controls a:visited,
    .hide-double-row-controls a:hover{
        color: #fff;
    } 
</style>

<table>
    <thead>
        <th>Name</th>
    </thead>
    <tbody>
        <?php foreach ($companies as $company): ?>
        <tr class="double-top">         
            <td><?php echo $company['Company']['name']; ?></td>
        </tr>
        <tr class="double-bottom">
            <td colspan="3" class="double-row-controls hide-double-row-controls">
                <?php echo $this->Html->link('View', '#'); ?>
                |
                <a href="#">Edit</a>
                |
                <?php echo $this->Html->link('New Case', '#'); ?>
                |
                <a href="#">Delete</a>
            </td>            
        </tr>        
        <?php endforeach; ?>
    </tbody>
</table>
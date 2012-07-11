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

<div class="row">
    <div class="two-thirds column alpha">

    <?php if(!empty($myRealtionships)): ?>
    <div id="ResultsPage">
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Relationship Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($myRealtionships as $relationship): ?>
                <tr>
                    <td>
                        <?php echo $relationship['first_name'] ?>
                    </td>
                    <td>
                        <?php echo $relationship['last_name'] ?>
                    </td>
                    <td>
                        <?php echo $relationship['username'] ?>
                    </td>
                    <td>
                        <?php
                        foreach($relationship['status'] as $key => $val):
                            echo Inflector::humanize($key).' | ';
                        endforeach;
                        ?>
                    </td>

                    <td>
                        <?php foreach($relationship['actions'] as $key => $val): ?>
                        <a href="<?php echo $val; ?>" >
                            <?php echo Inflector::humanize($key); ?>
                        </a> | 
                        <?php endforeach; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <?php

    else:
        echo $this->element('no_results', array('message'=>__("I'm sorry, there are no results to display.")));
    endif;

    ?>
    </div>
    <div class="one-third column omega"></div>
</div>
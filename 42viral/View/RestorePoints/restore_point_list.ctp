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
        <div id="ResultsPage">
            <?php if(!empty($restore_points)): ?>
				<table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Action</th>
                            <th>Changes</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php foreach($restore_points as $point): ?>
							<tr>
								<td>
								    <a
						href="/restore_points/restore_point_overview/<?php echo $point['RestorePoint']['id']; ?>">
						<?php echo $point['RestorePoint']['created']; ?>
								    </a>
								</td>
								<td>
								    <?php echo $point['RestorePoint']['model']; ?>
								</td>
								<td>
								    <?php echo $point['RestorePoint']['event']; ?>
								</td>
								<td>
								    <?php
								        if (strtoupper($point['RestorePoint']['event']) == 'CREATE') {
								            echo 'Record Created';
								        }
								        elseif (strtoupper($point['RestorePoint']['event']) == 'DELETE') {
								            echo 'Record Removed';
								        }
								        elseif (isset($point['AuditDelta'])) {
								            $index = count($point['AuditDelta'])-1;
								            if ($point['AuditDelta'][$index]['property_name'] == 'title' ||
								                $point['AuditDelta'][$index]['property_name'] == 'body') {
								                echo ucwords($point['AuditDelta'][$index]['property_name']);
								            }
								            else {
								                echo 'Other';
								            }
								        }
								    ?>
								</td>
							</tr>
                <?php endforeach; ?>
						</tbody>
					</table>
            <?php else: ?>
                <div class="no-results">
                    <div class="no-results-message">
                        <?php echo __("I'm sorry, there are no restore points to display."); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <div class="one-third column omega">
        <?php echo $this->element('Navigation' . DS . 'menus',
            array('section'=>strtolower($point['RestorePoint']['model'])));
        ?>
    </div>
</div>
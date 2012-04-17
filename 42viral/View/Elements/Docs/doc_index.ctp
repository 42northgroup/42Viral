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


<?php //debug($doc_nav_index); ?>

<a href="/doc/">Table of Contents</a>

<?php foreach($doc_nav_index as $key1 => $value1): ?>
    <?php if($key1 == '_root'): ?>
        <?php foreach($value1 as $key2 => $value2): ?>
            <ul>
                <li>
                    <a href="<?php echo $value2['url']; ?>">
                        <?php echo Inflector::humanize($value2['label']); ?>
                    </a>
                </li>
            </ul>
        <?php endforeach; ?>
    <?php else: ?>
        <h3><?php echo Inflector::humanize($key1); ?></h3>

        <?php foreach($value1 as $key2 => $value2): ?>
            <ul>
                <li>
                    <a href="<?php echo $value2['url']; ?>">
                        <?php echo Inflector::humanize($value2['label']); ?>
                    </a>
                </li>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endforeach; ?>

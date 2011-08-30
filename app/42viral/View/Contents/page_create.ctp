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
 * @package app
 * @package app.core
 * @author Jason D Snider <jsnider77@gmail.com>
 */
?>

<h1>Create a page</h1>
<?php

    echo $this->Form->create('Page', 
                array(
                    'url'=>$this->here, 
                    'class'=>'content'
                )
            );
    
    echo $this->Form->input('title', array('rows'=>1, 'cols'=>96));
    echo $this->Form->submit();
    echo $this->Form->end();

?>

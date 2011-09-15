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
<h1>Create an ACL Group</h1>
<?php

    echo $this->Form->create('AclGroup', 
                array(
                    'url'=>$this->here, 
                    'class'=>'default'
                )
            );
    echo $this->Form->input('name');
    echo $this->Form->input('alias');
    echo $this->Form->input('object_type', array(
        'type' => 'hidden',
        'value' => 'acl'
    ));
    
    echo $this->Form->submit();
    echo $this->Form->end();
?>
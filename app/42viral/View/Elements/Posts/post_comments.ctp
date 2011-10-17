<?php 
/**
 * Displays the appropriate commenting engine based on Config/app.php settings
 * 
 * Copyright (c) 2011,  MicroTrain Technologies (http://www.microtrain.net)
 * licensed under MIT (http://www.opensource.org/licenses/mit-license.php)
 *
 * @copyright Copyright 2010, MicroTrain Technologies (http://www.microtrain.net)
 * @package app
 * @subpackage app.core
 *** @author Jason Snider <jsnider77@gmail.com>
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 */

$commentEngine = Configure::read('Comment.engine');

if(isset($commentEngine)):
    echo $this->element('Posts' . DS . 'PostComments' . DS .  $commentEngine);
endif; 

?>
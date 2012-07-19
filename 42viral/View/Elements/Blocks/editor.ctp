<?php

$editWith = isset($use)?$use:'CKEditor';

switch($editWith){

    default:

        //Do any plugins want to use the navigation?
        $pluginPath = ROOT . DS . APP_DIR . DS . 'Plugin' . DS;
        $pluginEditorPath = 'View' . DS . 'Elements' . DS . 'editor.ctp';
        require_once($pluginPath . $editWith . DS . $pluginEditorPath);

    break;
}



<?php

$this->Asset->addAssets(array(
    'CKEditor' . DS . 'webroot' . DS . 'ckeditor' . DS . 'adapters' . DS . '42viral.js',
    'CKEditor' . DS . 'webroot' . DS . 'ckeditor' . DS . 'ckeditor.js',
    'CKEditor' . DS . 'webroot' . DS . 'ckeditor' . DS . 'adapters' . DS . 'jquery.js'
), 'ck_editor');

echo $this->Asset->buildAssets('js', 'ck_editor', false);
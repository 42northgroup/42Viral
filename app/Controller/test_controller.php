<?php
 
class TestsController extends AppController {
    var $name = 'Tests';
 
    var $autoRender = false;
 
    function index($url, $status = null, $exit = true) {
        echo 'hi';
    }
}
 
?>

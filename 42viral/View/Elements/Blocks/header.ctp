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

$profileId = $this->Session->read('Auth.User.Profile.id');
$username = $this->Session->read('Auth.User.username');
$userId = $this->Session->read('Auth.User.id');
?>

<div id="Header">
    <div class="clearfix squeeze">
        <div id="LogoContainer">
            <a href="/">The 42Viral Project</a>
        </div>

        <div id="MobileHeader" class="clearfix">

            <div class="logo-container">
                <a href="/">The 42Viral Project</a>
            </div>

            <a id="MobileNavigationTrigger" class="btn btn-navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

        </div>

        <div id="NavigationContainer">
            <div id="NavigationHeader">
                <a id="NavigationTrigger" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            </div>
            <?php echo $this->element('Navigation' . DS . 'menu_header'); ?>
        </div>

    </div>
</div>
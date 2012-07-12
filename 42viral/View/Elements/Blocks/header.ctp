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

            <div id="Navigation">
            <?php
                $headerMenuVars = unserialize($this->element('Navigation' . DS . 'menu_header'));
                $headerMenu = $headerMenuVars['headerMenu'];

                //Do any plugins want to use the navigation?
                $pluginMenuElementPath = 'View' . DS . 'Elements' . DS . 'menu_header_injection.ctp';
                foreach(App::path('Plugin') as $pluginPath){
                    foreach(scandir($pluginPath) as $plugin){
                        if(is_file($pluginPath . $plugin . DS . $pluginMenuElementPath)){
                            $pluginVars = unserialize($this->element("{$plugin}.menu_header_injection"));
                            $pluginItems = $pluginVars['pluginItems'];
                        }
                    }
                }

                if(!empty($pluginItems)){
                    $headerMenu['Items'] = array_merge($headerMenu['Items'], $pluginItems);
                }

                //Loop through this sections menu items
                foreach($headerMenu['Items'] as $item):

                    $item = $this->Menu->item($item);

                    //If $item is still set, show the link
                    if($item):
                        echo "<div class=\"navigation\">"; #2
                        echo $this->Html->link(
                            $item['text'],
                            $item['url'],
                            $item['options'],
                            $item['confirm']
                        );

                        if(isset($item['SubNavigation'])):
                            echo "<div class=\"subnavigation\">"; #3
                                foreach($item['SubNavigation'] as $subItem):
                                    $subItem = $this->Menu->item($subItem);
                                    echo "<div>"; #4
                                    echo $this->Html->link(
                                        $subItem['text'],
                                        $subItem['url'],
                                        $subItem['options'],
                                        $subItem['confirm']
                                    );
                                    echo "</div>"; #/4
                                endforeach;
                            echo "</div>"; #/3
                        endif;

                    echo "</div>"; #/2
                    endif;

                endforeach;
            ?>
            </div>
        </div>
    </div>
</div>
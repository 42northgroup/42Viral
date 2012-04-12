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

<div class="rows">
    <div class="two-thirds column alpha">
    <?php 

        echo $this->Form->create(
                null, 
                array(
                    'class'=>'responsive configurations', 
                    'url'=>$this->here)); 
        
        //Collect all core configuration form element directories
        $corePaths = array();
        foreach(App::path('View') as $corePath):
            if(is_dir($corePath . 'Elements' . DS . 'Configuration' . DS . 'Core')):
               $corePaths[]= $corePath . 'Elements' . DS . 'Configuration' . DS . 'Core';
            endif;
        endforeach;
        
        //Collect all plugin configuration form element directories
        $pluginPaths = array();
        foreach(App::path('View') as $pluginPath):
            if(is_dir($pluginPath . 'Elements' . DS . 'Configuration' . DS . 'Plugin')):
               $pluginPaths[]= $corePath . 'Elements' . DS . 'Configuration' . DS . 'Plugin';
            endif;
        endforeach;
        
        echo $this->Html->tag('h2', 'Core Configuration');
        
        foreach($corePaths as $coreElementPath):
            foreach(scandir($coreElementPath) as $core):
                if(is_file($coreElementPath . DS . $core)):
                    echo $this->Html->tag('h3', Inflector::humanize(str_replace('.ctp', '', $core)));
                    include($coreElementPath . DS . $core);
                endif;
            endforeach;
        endforeach;
        
        echo $this->Html->tag('h2', 'Plugin Configuration');
        
        foreach($pluginPaths as $pluginElementPath):
            foreach(scandir($pluginElementPath) as $plugin):
                if(is_file($pluginElementPath . DS . $plugin)):
                    echo $this->Html->tag('h3', Inflector::humanize(str_replace('.ctp', '', $plugin)));
                    include($pluginElementPath . DS . $plugin);
                endif;
            endforeach;  
        endforeach;

        echo $this->Form->submit();
        echo $this->Form->end();
    ?>
    </div>
</div>
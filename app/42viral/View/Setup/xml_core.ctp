<style type="text/css">
    label{
        display: block;
    }
    
    input[type='text']{
        width: 98%;
    }
</style>
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
 * @author Jason D Snider <jason.snider@42viral.org>
 */

echo $this->element('Navigation' . DS . 'local', array('section'=>'configuration', 'class'=>'config'));
echo $this->Form->create(null, array('url'=>$this->here));

foreach($xmlData['root']['groups'] as $groups):
    
    foreach($groups as $group): 
        echo '<div style="margin:24px 0 0; background: #efefef; padding:12px 8px; border-radius: 4px;">';
        foreach($group as $setting): 
            if(count($setting) > 1):
                echo $this->Form->input(
                        $setting['setting'], 
                        array(
                            //'name'=>"data[{$setting['setting']}]", 
                            'label'=>$setting['setting'], 
                            'value'=>$setting['value'],
                            'type'=>'text'
                            )
                        );
            else:
                echo $this->Form->input(
                        $group['setting'], 
                        array(
                            //'name'=>"data[{$setting['setting']}]", 
                            'label'=>$group['setting'], 
                            'value'=>$group['value'],
                            'type'=>'text'
                            )
                        );
                BREAK;
            endif;
        endforeach;
        echo '</div>';
    endforeach;
endforeach;

echo $this->Form->submit('Save Configuration', 
        array('before'=>$this->Form->input('Control.next_step', 
                array(
                    'type'=>'checkbox', 
                    'div'=>false, 
                    'style'=>'margin-right: 6px;',
                    'checked'=>true,
                    'label'=>array('style'=>'display:inline; margin-right: 6px;')))));


echo $this->Form->end();
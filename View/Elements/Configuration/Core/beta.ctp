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

    echo $this->Form->inputs(array(
            'legend'=>'Beta Mode',

            'Betaprivate.id'=>array('value'=>'Beta.private', 'type'=>'hidden'),
            'Betaprivate.value'=>array(
                'label'=>array(
                    'text'=>'New Members Can Only Join if Invited',
                    'class'=>'help',
                    'title'=>'If checked new accounts may only be created by invite only.'
                ),
                'type'=>'checkbox'
            ),

            'Betainvitations.id'=>array('value'=>'Beta.invitations', 'type'=>'hidden'),
            'Betainvitations.value'=>array(
                'label'=>array(
                    'text'=>'Number of Ivitations Per User (0 for inifinite)',
                    'class'=>'help',
                    'title'=>'How many invites is each user allowed to send.'
                )
            )
    ));
?>


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

App::uses('Scrub', 'Lib');
?>

<div class="row">

    <div class="two-thirds column alpha">
        <div class="icon-bar">
            <?php echo $this->SocialMedia->landingPage($person, $networks); ?>
        </div>
        <div class="h1shim"></div>
        <div id="ResultsPage">
            <h2><?php echo ProfileUtil::name($person['Person']); ?>'s Content</h2>

            <?php foreach($contents as $content):?>
                <div class="clearfix result" style="width: 100%;">
                    <div class="result-left">
                        <?php echo Inflector::humanize($content['Content']['object_type']); ?>
                    </div>
                    <div class="result-right">

                        <strong><?php echo $this->Html->link($content['Content']['title'],
                                $content['Content']['url']); ?> </strong>

                        <div class="tease">
                            <?php echo Scrub::noHtml(
                                    $this->Text->truncate(
                                            $content['Content']['body'], 180, array('html' => true))); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php echo $this->element('paginate'); ?>
        </div>
    </div>

    <div class="one-third column omega">

        <?php
            echo $this->element(
                    'Blocks' . DS . 'hcard',
                    array(
                            'hcardPerson'=>$person,
                            'hcardProfile'=>$person['Profile'],
                            'hcardPhoneNumbers'=>$person['PhoneNumber'],
                            'hcardEmailAddresses'=>$person['EmailAddress'],
                            'hcardAddresses'=>$person['Address'],
                            'h1'=>true
                        )
                    );

            echo $this->element(
                'Navigation' . DS . 'menus',
                array(
                    'section'=>'profile',
                    'menuPerson'=>$person
                )
            );

        ?>

    </div>

</div>
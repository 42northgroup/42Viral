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
App::uses('Utility', 'Lib');
?>

<div class="row">

    <div class="two-thirds column alpha">
        <section>
            <h1>Profile</h1>
            <div><?php echo $person['Person']['bio']; ?></div>
        </section>

        <section>
            <h2>Address</h2>
            <?php foreach($person['Address'] as $address): ?>
                <div>Label: <?php echo !empty($address['label'])?$address['label']:$address['label']; ?></div>
                <div><?php echo !empty($address['line1'])?$address['line1']:$address['line1']; ?></div>
                <div><?php echo !empty($address['line2'])?$address['line2']:$address['line2']; ?></div>
                <div>
                    <?php

                        echo !empty($address['city'])?$address['city']:$address['city'];

                        if(!empty($address['state'])){
                            echo (!empty($address['city']) && !empty($address['state']))?', ':'';
                            echo $address['state'];
                        }
                        echo (!empty($address['city']) && !empty($address['state']))?' ':'';
                        echo !empty($address['zip'])?$address['zip']:$address['zip'];
                   ?>
                </div>
                <div>
                    <?php
                        echo !empty($address['country'])?$address['country']:$address['country'];
                        //echo (!empty($address['country']) && !empty($address['planet']))?', ':'';
                        //echo !empty($address['planet'])?$address['planet']:$address['planet'];
                    ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>Email Addresses</h2>
            <?php foreach($person['EmailAddress'] as $emailAddress): ?>
                <div>
                <?php
                    echo $emailAddress['label'] . ': ';
                    echo $emailAddress['email_address'];
                ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>Phone Numbers</h2>
            <?php foreach($person['PhoneNumber'] as $phoneNumbers): ?>
                <div>
                <?php
                    echo $phoneNumbers['label'] . ': ';
                    echo $phoneNumbers['phone_number'];
                ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section>
            <h2>Social Networks</h2>
            <?php foreach($person['SocialNetwork'] as $socialNetwork): ?>
                <div>
                <?php
                    echo $this->Html->link($socialNetwork['network'], $socialNetwork['profile_url']);
                ?>
                </div>
            <?php endforeach; ?>
        </section>
    </div>

    <div class="one-third column omega">

        <?php
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
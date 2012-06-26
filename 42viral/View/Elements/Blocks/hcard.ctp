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

App::uses('Handy', 'Lib');

//Do we want the image label to provide this page's h1 tag?
$tag = $h1?'h1':'span';

?>
<?php if(isset($hcardPerson)):?>
    <div class="column-block clearfix">
        <div class="vcard">
            <div class="image-frame" style="width: 100%; margin: 0 10px 6px 0;">
                <?php echo $this->Profile->avatar($hcardPerson['Person'], '100%'); ?>
                <div class="image-title">
                    <<?php echo $tag; ?> class="fn">
                        <?php echo $this->Profile->name($hcardPerson['Person']); ?>
                    </<?php echo $tag; ?>>
                </div>
            </div>

            <?php if(!empty($hcardProfile['bio'])): ?>
                <div>
                    <!-- <h4>Bio</h4> -->
                    <?php echo $hcardProfile['bio']; ?>
                </div>
            <?php endif; ?>

            <div id="VcardDetails">

                <?php if(!empty($hcardPhoneNumbers)): ?>
                    <div class="column-block details-block">
                    <!-- <h4>Phone Numbers</h4> -->
                        <?php foreach ($hcardPhoneNumbers as $phoneNumber): ?>
                            <div class="tel">
                                <span class="type"><?php echo $phoneNumber['label'] ?>: </span>
                                <span class="value"><?php echo Handy::phoneNumber($phoneNumber['phone_number']) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($hcardEmailAddresses)): ?>
                    <div class="column-block details-block">
                    <!--  <h4>Email Addresses</h4> -->
                        <?php foreach ($hcardEmailAddresses as $emailAddress): ?>
                            <div class="email">
                                <span class="type"><?php echo $emailAddress['label'] ?>: </span>
                                <span class="value"><?php echo $emailAddress['email_address']; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($hcardAddresses)): ?>
                    <div class="column-block details-block">
                        <!-- <h4>Addresses</h4> -->
                        <?php foreach ($hcardAddresses as $address): ?>
                        <div class="adr">
                            <span class="type"> <?php echo $address['label'] ?>: </span>

                            <?php if(!empty($address['line1'])): ?>
                                <span class="street-address" >
                                    <?php echo $address['line1']; ?>
                                    <?php echo !empty($address['line2'])?", {$address['line2']}":""; ?>
                                </span>
                            <?php endif; ?>

                            <?php if(!empty($address['city'])): ?>
                                <span class="locality">
                                    <?php echo $address['city'] ?>
                                </span>
                                <?php !empty($address['city']) && !empty($address['state'])?", ":""; ?>
                            <?php endif; ?>

                            <?php if(!empty($address['state'])): ?>
                                <span class="region" >
                                    <?php echo $address['state'] ?>
                                </span>
                            <?php endif; ?>

                            <?php if(!empty($address['zip'])): ?>
                                <span class="postal-code" >
                                    <?php echo $address['zip'] ?>
                                </span>
                            <?php endif; ?>

                            <?php if(!empty($address['country'])): ?>
                                <span class="country-name" >
                                    <?php echo ", {$address['country']}"; ?>
                                </span>
                            <?php endif; ?>

                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
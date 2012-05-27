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

//Do we show the full vard by default
$allOpen = isset($allOpen)?'block':'none';

//Do we want the image label to rpovide this page's h1 tag?
$tag = isset($h1)?'h1':'span';

$limited = isset($limited)?true:false;
?>
<?php if(isset($userProfile)):?>
    <div class="column-block clearfix">
        <div class="vcard">
            <div class="image-frame" style="width: 100%; margin: 0 10px 6px 0;">
                <?php echo $this->Profile->avatar($userProfile['Person'], '100%'); ?>
                <div class="image-title">
                    <<?php echo $tag; ?> class="fn">
                        <?php echo $this->Profile->name($userProfile['Person']); ?>
                    </<?php echo $tag; ?>>
                </div>
            </div>

            <div>
                <?php echo $userProfile['Profile']['bio']; ?>
            </div>
            
            <?php if(!$limited): ?>
                <div id="VcardDetails" style="display:<?php echo $allOpen ?>;">

                    <?php if(count(Set::extract('/PersonDetail[type=phone]', $userProfile)) > 0): ?>
                        <div class="column-block details-block">
                        <h4>Phone Numbers</h4>
                            <?php foreach ($userProfile['PersonDetail'] as $phone): ?>
                                <?php if($phone['type'] == 'phone'): ?>
                                <div class="tel">
                                    <span class="type"><?php echo $phone['category'] ?>: </span>
                                    <span class="value"><?php echo Handy::phoneNumber($phone['value']) ?></span>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                        
                    <?php if(count(Set::extract('/PersonDetail[type=email]', $userProfile)) > 0): ?>
                        <div class="column-block details-block">
                            <h4>Emails</h4>
                            <?php foreach ($userProfile['PersonDetail'] as $email): ?>
                                <?php if($email['type'] == 'email'): ?>
                                <div class="email">
                                    <span class="type"><?php echo $email['category'] ?>: </span>
                                    <span class="value"><?php echo Handy::email($email['value']) ?></span>
                                </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(!empty($userProfile['Address'])): ?>
                        <div class="column-block">
                            <h4>Addresses</h4>
                            <?php foreach ($userProfile['Address'] as $address): ?>
                            <div class="adr" style="float:left; margin-right: 20px;" >
                                <div class="type" style=" font-weight: bold">
                                    <?php echo $address['type'] ?>
                                </div>
                                
                                <?php if(!empty($address['line1'])): ?>
                                    <div class="street-address" >
                                        <?php echo $address['line1']; ?>
                                        <?php !empty($address['line2'])?", {$address['line2']}":""; ?>
                                    </div>
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
                                    <div class="country-name" >
                                        <?php echo $address['country']; ?>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
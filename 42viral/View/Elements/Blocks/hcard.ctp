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


//Do we show the full vard by default
$allOpen = isset($allOpen)?'block':'none';

//Do we want the image label to rpovide this page's h1 tag?
$tag = isset($h1)?'h1':'span';
?>
<?php if(isset($userProfile)):?>
    <div class="column-block clearfix">
        <div class="vcard">
            <div class="image-frame" style="float:left; margin: 0 10px 6px 0;">
                <?php echo $this->Member->avatar($userProfile['Person']); ?>
                <div class="image-title">
                    <<?php echo $tag; ?> class="fn">
                        <?php echo $this->Member->name($userProfile['Person']); ?>
                    </<?php echo $tag; ?>>
                </div>
            </div>

            <div>
                <?php echo $userProfile['Profile']['bio']; ?>
            </div>
            
            <br class="clear" />
            
            <div id="VcardDetails" style="display:<?php echo $allOpen ?>;">
                
                <?php if(count(Set::extract('/PersonDetail[type=phone]', $userProfile)) > 0): ?>
                    <h4>Phone Numbers</h4>
                    <?php foreach ($userProfile['PersonDetail'] as $phone): ?>
                        <?php if($phone['type'] == 'phone'): ?>
                        <div class="tel">
                            <span class="type"><?php echo $phone['category'] ?>: </span>
                            <span class="value"><?php echo $phone['value'] ?></span>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                    
                <?php if(count(Set::extract('/PersonDetail[type=email]', $userProfile)) > 0): ?>
                    <h4>Emails</h4>
                    <?php foreach ($userProfile['PersonDetail'] as $email): ?>
                        <?php if($email['type'] == 'email'): ?>
                        <div class="email">
                            <span class="type"><?php echo $email['category'] ?>: </span>
                            <span class="value"><?php echo $email['value'] ?></span>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <?php if(!empty($userProfile['Address'])): ?>
                    <h4>Addresses</h4>
                    <?php foreach ($userProfile['Address'] as $address): ?>
                    <div class="adr" style="float:left; margin-right: 20px;" >
                        <div class="type" style=" font-weight: bold">
                            <?php echo $address['type'] ?>
                        </div>
                        <div class="street-address" >
                            <?php echo $address['line1'].', '.$address['line2']; ?>
                        </div>
                        <span class="locality">
                            <?php echo $address['city'] ?>
                        </span>, 
                        <span class="region" >
                            <?php echo $address['state'] ?>
                        </span>, 
                        <span class="postal-code" >
                            <?php echo $address['zip'] ?>
                        </span>
                        <div class="country-name" >
                            <?php echo $address['country']; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
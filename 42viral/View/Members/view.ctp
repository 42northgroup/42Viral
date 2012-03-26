<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    
    <div class="two-thirds column alpha">
        <div style="padding:4px 0 0;"><?php echo $user['Profile']['tease']; ?></div>
        <div id="ResultsPage">

            <h2>Social Media Stream</h2>

            <?php 
            if( isset($statuses['connection']) ):
                foreach($statuses['connection'] as $key => $val):
                    echo $key . __(' does not seem to be responding, please try again later.') . '<br/>';
                endforeach;
            endif; 
            ?>

            <?php foreach ($statuses['posts'] as $status): ?>

                <?php if($status['post'] != ''): ?>
                <div class="clearfix status">
                    <div style="float:left; width: 40px;">
                    <?php 
                        echo $this->Html->image(
                                "/img/social_media_icons/social_networking_iconpack/{$status['source']}_32.png"); 
                    ?>
                    </div>
                    <div style="float:left; width: 510px;">
                        <?php echo $this->Html->div(null, $status['post']); ?>
                        <div class="status-details">
                            <?php echo isset($status['time'])? date('F jS \a\t h:ia', $status['time']):''; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php endforeach;?>            

        </div>        
    </div>
    
    <div class="one-third column omega">
    <div class="vcard">
        <h1 class="fn" ><?php echo $user['User']['name']; ?></h1>
        
        <h3>Phone Numbers</h3>

        <?php foreach ($person_details['phones'] as $phone): ?>
        <div class="tel">
            <span class="type"><?php echo $phone['PersonDetail']['category'] ?>: </span>
            <span class="value"><?php echo $phone['PersonDetail']['value'] ?></span>
        </div>
        <?php endforeach; ?>
        
        <h3>Emails</h3>
        <?php foreach ($person_details['emails'] as $email): ?>
        <div class="email">
            <span class="type"><?php echo $email['PersonDetail']['category'] ?>: </span>
            <span class="value"><?php echo $email['PersonDetail']['value'] ?></span>
        </div>
        <?php endforeach; ?>
       
        <h3>Addresses</h3>
        <?php foreach ($addresses as $address): ?>
        <div class="adr" style="float:left; margin-right: 20px;" >
            <div class="type" style=" font-weight: bold">
                <?php echo $address['Address']['type'] ?>
            </div>
            <div class="street-address" >
                <?php echo $address['Address']['line1'].', '.$address['Address']['line2']; ?>
            </div>
            <span class="locality">
                <?php echo $address['Address']['city'] ?>
            </span>, 
            <span class="region" >
                <?php echo $address['Address']['state'] ?>
            </span>, 
            <span class="postal-code" >
                <?php echo $address['Address']['zip'] ?>
            </span>
            <div class="country-name" >
                <?php echo $address['Address']['country']; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
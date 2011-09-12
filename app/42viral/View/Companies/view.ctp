<?php //pr($company); ?>
<?php //pr($web_results); ?>
<?php //pr($web_results['yelp']); ?>

<div class="clearfix">
    <h1 style="float:left;"><?php echo $company['Company']['name']; ?></h1>

    <div style="float:right;">
    <?php 
        if($mine):
            
            echo $this->Html->link('Edit', $company['Company']['edit_url']);
            echo " / ";
            echo $this->Html->link('Delete', $company['Company']['delete_url'], 
                    null, 
                    Configure::read('System.purge_warning'));
        endif; 
    ?>
    </div>
</div>

<div><?php echo $company['Company']['body']; ?></div>
<?php if(isset($company['Address']) && !empty($company['Address'])): ?>
    <h2>Locations</h2>
    <table>
        <tbody>
            <?php foreach($company['Address'] as $tempAddress): ?>
                <tr>
                    <td><?php echo $tempAddress['_us_full_address']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<hr />

<h2>See what people are saying about <?php echo $company['Company']['name']; ?></h2>

<div style="border: 2px solid #007; padding: 10px; margin: 10px;">
    <img src="http://l.yimg.com/a/i/brand/purplelogo/uh/us/local.gif"
         title="Yahoo Local Search Results"
         alt="Yahoo Local Search Results" />
    
    <?php if($web_results['yahoo']['totalResultsAvailable'] <= 0): ?>

        <h3>No listings found</h3>
        
        <?php 
            if(!$connect['yahoo']):
                echo 'Yahoo! does not seem to be responding, please try again later.';
            endif; 
        ?>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <td>Company Name</td>
                    <td>Address</td>
                </tr>
            </thead>

            <tbody>
                <?php if($web_results['yahoo']['totalResultsAvailable'] == 1): ?>

                    <tr>
                        <td>
                            <a href="<?php echo $web_results['yahoo']['Result']['Url']; ?>">
                                <?php echo $web_results['yahoo']['Result']['Title']; ?>
                            </a>

                        </td>

                        <td>
                            <?php echo $web_results['yahoo']['Result']['Address']; ?>
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach($web_results['yahoo']['Result'] as $tempResult): ?>
                        <tr>
                            <td>
                                <a href="<?php echo $tempResult['Url']; ?>" target="_blank">
                                    <?php echo $tempResult['Title']; ?>
                                </a>
                            </td>

                            <td>
                                <?php echo $tempResult['Address']; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>
        </table>

    <?php endif; ?>
</div>


<div style="border: 2px solid #700; padding: 10px; margin: 10px;">
    <a href="http://www.yelp.com">
        <img src="http://myelp4-a.akamaihd.net/static/20101216149848283/img/developers/yelp_logo_75x38.png"
             title="Yelp Results"
             alt="Yelp Results"/>
    </a>

    <?php if($web_results['yelp']['total'] <= 0): ?>

        <h3>No listings found</h3>
        <?php 
            if(!$connect['yelp']):
                echo 'Yelp does not seem to be responding, please try again later.';
            endif; 
        ?>
    <?php else: ?>

        <table>
            <tbody>
                <?php foreach($web_results['yelp']['businesses'] as $tempBusiness): ?>
                    <tr>
                        <td>
                            <?php $tempBusiness = (array) $tempBusiness; ?>
                                <?php //debug($tempBusiness); ?>

                                <img src="<?php echo $tempBusiness['rating_img_url']; ?>"
                                     title="Yelp Rating" />
                                <?php
                                echo
                                    $tempBusiness['review_count'] . ' ' .
                                    (($tempBusiness['review_count'] == 1)? 'review': 'reviews');
                                ?><br />

                                <a href="<?php echo $tempBusiness['url']; ?>"
                                   style="font-size: 14px; font-weight: bold;"
                                   target="_blank"><?php
                                    echo $tempBusiness['name'];
                                ?></a>
                                <br />

                                <a href="<?php echo $tempBusiness['url']; ?>"
                                   target="_blank">Read Reviews</a>
                            <?php ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>
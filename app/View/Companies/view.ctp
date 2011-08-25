<?php //pr($company); ?>
<?php //pr($web_results); ?>

<h1>Company Details</h1>

<h2><u>Name</u>: <?php echo $company['Company']['name']; ?></h2>

<?php if(isset($company['Address']) && !empty($company['Address'])): ?>
    <h4>Addresses:</h4>

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

<h1>Web Results</h1>

<h2>Yahoo Local Search Results</h2>

<?php if($web_results['yahoo']['totalResultsAvailable'] <= 0): ?>

    <h3>No listings found</h3>

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

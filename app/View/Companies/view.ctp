<?php //pr($company); ?>
<?php //pr($web_results); ?>

<h1>Web Results</h1>

<h2>Yahoo Local Search Results</h2>

<table>
    <thead>
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
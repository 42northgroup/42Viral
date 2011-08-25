<?php //pr($results); ?>
<?php //pr(count($results['yahoo']['totalResultsAvailable'])); ?>

<h2>Yahoo Local Search Results</h2>

<table>
    <thead>
    </thead>

    <tbody>
        <?php if($results['yahoo']['totalResultsAvailable'] == 1): ?>

            <tr>
                <td>
                    <a href="<?php echo $results['yahoo']['Result']['Url']; ?>">
                        <?php echo $results['yahoo']['Result']['Title']; ?>
                    </a>

                </td>

                <td>
                    <?php echo $results['yahoo']['Result']['Address']; ?>
                </td>
            </tr>

        <?php else: ?>

            <?php foreach($results['yahoo']['Result'] as $tempResult): ?>
                <tr>
                    <td>
                        <a href="<?php echo $tempResult['Url']; ?>">
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
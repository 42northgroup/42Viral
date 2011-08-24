<?php //pr($results); ?>
<?php //pr(count($results['yahoo']['totalResultsAvailable'])); ?>

<table>
    <thead>
    </thead>

    <tbody>
        <?php if(count($results['yahoo']['totalResultsAvailable']) == 1): ?>

            <tr>
                <td>
                    <?php echo $results['yahoo']['Result']['Title']; ?>

                </td>

                <td>
                    <?php echo $results['yahoo']['Result']['Address']; ?>
                </td>
            </tr>

        <?php else: ?>

            <?php foreach($results['yahoo']['Result'] as $tempResult): ?>
                <tr>
                    <td>
                        <?php echo $tempResult['Title']; ?>

                    </td>

                    <td>
                        <?php echo $tempResult['Address']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>

    </tbody>
</table>
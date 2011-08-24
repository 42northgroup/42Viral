<?php //debug($result_set); ?>

<table>
    <thead>
    </thead>

    <tbody>
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

    </tbody>
</table>
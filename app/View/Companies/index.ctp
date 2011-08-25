<?php //debug($companies); ?>

<h1>Companies</h1>

<table>
    <thead>
        <tr>
            <td>Name</td>
            <td>Address</td>
            <td>Phone</td>
            <td>Listings</td>
        </tr>
    </thead>

    <tbody>
        <?php foreach($companies as $tempCompany): ?>
            <tr>
                <td>
                    <a href="/company_profile/<?php echo $tempCompany['Company']['name_normalized']; ?>">
                        <?php echo $tempCompany['Company']['name']; ?>
                    </a>
                </td>

                <td>
                    <?php if(isset($tempCompany['Address']) && !empty($tempCompany['Address'])): ?>
                        <table>
                            <?php foreach($tempCompany['Address'] as $tempAddress): ?>
                                <tr>
                                    <td><?php echo $tempAddress['_us_full_address']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </td>

                <td>
                    <?php echo $tempCompany['Company']['phone1']; ?>
                </td>

                <td></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
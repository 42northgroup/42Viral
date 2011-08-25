<?php //pr($companies); ?>

<h1>Company Details</h1>

<?php foreach($companies as $tempCompany): ?>
    <h2>
        <u>Name</u>:
        <a href="/company_profile/<?php echo $tempCompany['Company']['name_normalized']; ?>">
            <?php echo $tempCompany['Company']['name']; ?>
        </a>
    </h2>

    <?php if(isset($tempCompany['Address']) && !empty($tempCompany['Address'])): ?>
        <h4>Addresses:</h4>

        <table>
            <tbody>
                <?php foreach($tempCompany['Address'] as $tempAddress): ?>
                    <tr>
                        <td><?php echo $tempAddress['_us_full_address']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endforeach; ?>

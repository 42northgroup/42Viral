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
                    <?php echo $tempCompany['Company']['name']; ?>
                </td>

                <td>
                    <?php echo $tempCompany['Company']['_full_address']; ?>
                </td>

                <td>
                    <?php echo $tempCompany['Company']['phone1']; ?>
                </td>

                <td></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
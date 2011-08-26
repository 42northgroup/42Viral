<style type="text/css">
    div.section-box {
        border: 1px solid #ccc;
        padding: 5px;
        margin: 5px;
    }
</style>

<?php //pr($companies); ?>

<h1>Company Details</h1>

<a href="/companies/create">Create New Company</a>

<div class="section-box">
    <?php if(!empty($companies)): ?>

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

    <?php else: ?>

        No companies created yet.  <a href="/companies/create">Create one</a>

    <?php endif; ?>
</div>
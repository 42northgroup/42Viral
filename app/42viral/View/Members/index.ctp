

<h1>Profiles</h1>

<div id="ResultsPage">
    <?php foreach($users as $user):?>

        <div class="clearfix">  

            <div style="float:left; width:74px">
                <?php echo $this->Member->avatar($user['User'], 64); ?>
            </div>

            <div style="float:left;  width:500px">
                <h2><?php echo $this->Member->displayName($user['User']); ?></h2>
                <?php echo $this->Text->truncate($user['Profile']['bio'], 170); ?>
            </div>
        </div>
        <hr />

    <?php endforeach; ?>
</div>

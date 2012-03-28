<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha">
        <div id="ResultsPage" class="container">
            <?php foreach($users as $user):?>
                <div class="row result">
                    <div class="two columns alpha">
                        <div class="image-frame"><?php echo $this->Member->avatar($user['User'], 64); ?></div>
                    </div>

                    <div class="fourteen columns omega">
                        <h2><?php echo $this->Member->displayName($user['User']); ?></h2>
                        <?php echo $this->Text->truncate($user['Profile']['tease'], 
                                170, array('ending' => '...', 'exact' => true, 'html' => true)); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="one-third column omega">
        this is a test
    </div>
</div>

<?php echo $this->element('Navigation' . DS . 'local', array('section'=>'members')); ?>

<div id="ResultsPage">
    <?php foreach($users as $user):?>

        <div class="clearfix status">  

            <div style="float:left; width:74px">
                <?php echo $this->Member->avatar($user['User'], 64); ?>
            </div>

            <div style="float:left;  width:500px">
                <h2><?php echo $this->Member->displayName($user['User']); ?></h2>
                <?php echo $this->Text->truncate($user['Profile']['tease'], 
                        170, array('ending' => '...', 'exact' => true, 'html' => true)); ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>

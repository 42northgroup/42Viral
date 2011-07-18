<h1>Profiles</h1>

<?php foreach($users as $user):?>
    <div>            
        <h2><?php echo $this->Html->link($user['User']['username'], $user['User']['url']); ?></h2>
    </div>
<?php endforeach; ?>

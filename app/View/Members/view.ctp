<style type="text/css">
    
    div.profile-pic{
        float: left;
        width: 128px;
        height: 128px;
        margin: 0 16px 8px 0;
    }
    
    div.profile-bio{}
    
</style>

<h1><?php echo $user['User']['username']; ?></h1>


<div class="clearfix">
    
    <div class="profile-bio">
        
        <div class="profile-pic"></div>
        
        <?php echo $user['User']['bio']; ?>
        
    </div>
    
</div>

<h1><?php echo "{$user['User']['username']}'s Content" ?></h1>

<table>
    <thead>
        <tr>
            <th>Type</th>
            <th>Title</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($user['Content'] as $content):?>
        <tr>        
            <td>
                <?php echo Inflector::humanize($content['object_type']); ?>
            </td>
            <td>
               <?php echo $this->Html->link($content['title'], $content['url']); ?> 
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

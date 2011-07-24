<style type="text/css">
    
    div.profile-pic{
        width: 128px;
        height: 128px;
        margin: 20px 0 0;
    }
    
    div.profile-column-left{
        float: left;
        width: 150px;
    }
    
    div.profile-column-right{
        float: left;
        width: 640px;
    }
    
</style>

<div class="clearfix">
     
    <div class="profile-column-left">
        <div class="profile-pic">
            <?php echo $this->Html->image(
                    'https://secure.gravatar.com/avatar/' 
                        . md5( strtolower( trim( $user['User']['email'] ) ) ) . '?r=pg&amp;s=128'
                    );
            ?>
        </div>
    </div>
    
    <div class="profile-column-right">
        <h1><?php echo $user['User']['name']; ?></h1>
        <?php echo $user['User']['bio']; ?>

        <table>
            <caption>Content</caption>
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
    </div>
    
</div>

<?php if(isset($this->params['pass'][0])): ?>

    <h1>Post to the blog</h1>
    
    <?php

        echo $this->Form->create('Post', 
                    array(
                        'url'=>$this->here, 
                        'class'=>'content'
                    )
                );
        echo $this->Form->input('parent_content_id', array('value'=>$this->params['pass'][0], 'type'=>'hidden'));
        echo $this->Form->input('title', array('rows'=>1, 'cols'=>62));
        echo $this->Form->submit();
        echo $this->Form->end();

    ?>
    
<?php else: ?>

    <h1>Choose the blog you would like to post to</h1>
    <table>
        <tbody>
        <?php foreach($blogs as $blog): ?>
            <tr>
                <td>
                    <?php echo $this->Html->link(
                            $blog['Blog']['title'], "/contents/post_create/{$blog['Blog']['id']}"); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

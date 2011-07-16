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
        echo $this->Form->input('title', array('rows'=>1, 'cols'=>85));
        echo $this->Form->input('canonical', array('rows'=>2, 'cols'=>85));
        echo $this->Form->input('body', array('rows'=>20, 'cols'=>85));
        echo $this->Form->input('tease', array('rows'=>6, 'cols'=>85));
        echo $this->Form->input('description', array('rows'=>6, 'cols'=>85));
        echo $this->Form->input('keywords', array('rows'=>6, 'cols'=>85));
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
                    <?php echo $this->Html->link('[E]', "/profiles/blog_edit/{$blog['Blog']['id']}"); ?>
                    /<?php echo $this->Html->link('[D]', 
                            "/profiles/blog_delete/{$blog['Blog']['id']}", null, 
                                    'This will remove your blog and all of it\'s posts!\nAre you sure?\n'
                                    .'THERE IS NO GOING BACK!'); ?> 
                </td>
                <td>
                    <?php echo $this->Html->link(
                            $blog['Blog']['title'], "/profiles/post_create/{$blog['Blog']['id']}"); ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<div class="column-block">
    <div class="navigation-block">
        <?php
            echo $this->Html->tag('h4', __('Tag Cloud'));
            echo $this->TagCloud->display($tags, array(
                'before' => '<span style="font-size:%size%%" class="tag">',
                'after' => '</span>',
                'url'=>array(
                    'controller' => 'searches',
                    'action' => '/advanced/title:/body:/object_type:blog%20page%20post/status:published/',
                    ),
                'named'=>'tags'
                )
            );
        ?>
    </div>
</div>

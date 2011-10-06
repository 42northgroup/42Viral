<div class="side-navigation">
<?php
    if(isset($tags)):
        echo $this->Html->tag('h4', __('Tag Cloud'));
        echo $this->TagCloud->display($tags, array(
			'before' => '<span style="font-size:%size%%" class="tag">',
			'after' => '</span>',
            'url'=>array(
                'controller' => 'searches',
                'action' => 'tags'
                )
            )
        );
    endif;
?>
</div>
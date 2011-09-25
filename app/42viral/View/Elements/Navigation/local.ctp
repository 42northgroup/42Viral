<?php

$menu = array();

switch($section){
    
    case 'company':
        $menu = array(
            'name'=>'Companies',
            'Items' => array(
                array(
                    'text'=>'Index',
                    'url'=>'/companies',
                    'options' => array(),
                    'confirm'=>null
                ),
                
                array(
                    'text'=>'Create',
                    'url'=>'/companies/create',
                    'options' => array(),
                    'confirm'=>null
                )
            )
        );
    break;    

}

if(isset($additional)){
    $menu['Items'] = array_merge($menu['Items'], $additional);
}

?>


<div id ="SectionManager" class="clearfix profile-navigation">
    
    <h1 style="float:left; font-size: 100%; font-weight: normal;">
        <?php 
            // DO NOT!!! do an isset check here to supress errors. If their is an error finding the title, resolve it at
            // the controller level by using $this->set('title_for_layout') this will help assure page title are being 
            // set.
            echo $title_for_layout; 
        ?>
    </h1>
    
    <div style ="position:relative; float:right;">
        <?php if(count($menu['Items']) > 0): ?>
        
            <?php echo $this->Html->link($menu['name'], '#', 
                    array('id'=>'Manage', 'class'=>'section-navigation-link')); ?>

            <div id="ManageBlock" class="section-navigation-block">
                <?php foreach($menu['Items'] as $item): ?>
                    <?php echo $this->Html->link($item['text'], $item['url'], $item['options'], $item['confirm']); ?>
                <?php endforeach; ?>
            </div>
        
        <?php else: ?>
            <?php echo $menu['name']; ?>
        <?php endif; ?>
    </div>
    
</div>
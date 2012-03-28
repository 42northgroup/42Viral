<h1><?php echo $title_for_layout; ?></h1>
<div class="row">
    <div class="two-thirds column alpha"><?php echo $page['Page']['body']; ?></div>
    <div class="one-third column omega">
    <?php 
            //Privides navigation for manageing an asset
            if($this->Session->read('Auth.User.employee')):

                //If it's your post you'll be provided CMS links
                $additional = array(
                    array(
                        'text' => 'Edit',
                        'url' => "/admin/pages/edit/{$page['Page']['id']}",
                        'options'=>array(),
                        'confirm'=>null
                    ),
                    array(
                        'text' => 'Delete',
                        'url' => "/admin/pages/delete/{$page['Page']['id']}",
                        'options'=>array(),
                        'confirm'=>Configure::read('System.purge_warning')
                    )                
                );
                        
                echo $this->element('Navigation' . DS . 'manage', 
                            array('section'=>'page', 
                                'additional'=>$additional
                            )
                        );
            endif; 
        ?>        
    </div>
</div>
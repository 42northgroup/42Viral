<div id="Banner">
    <div id="BannerLeft">The 42Viral Project</div>
    <div id="BannerContent">
        <?php echo $this->Html->link('Profile', '/members/view/' ); ?>
        <?php echo $this->Html->link('Content', '/contents/content/' ); ?>
        
        <?php echo $this->Html->link('Photos', '/uploads/images/' ); ?>
        <?php echo $this->Html->link('Companies', '/companies/mine/' ); ?>
        <?php echo $this->Html->link('Connect', '/oauth/connect/' ); ?>
        
        <div>
        <?php
        
            switch($this->request->params['controller']){
                case 'contents';
                    echo $this->Html->link('Create a Blog', '/contents/blog_create/' );
                    echo ' / ';
                    echo $this->Html->link('Create a Blog', '/contents/post_create/' );
                break;     
            }
            
        ?>
        </div>
        
    </div>
    <div id="BannerRight"></div>
</div>
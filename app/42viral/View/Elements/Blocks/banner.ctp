<div id="Banner">
    <div id="BannerLeft">The 42Viral Project</div>
    <div id="BannerContent">
        <div class="banner-navigation">
            <?php echo $this->Html->link('Profile', '/members/view/' ); ?>
            <?php echo $this->Html->link('Content', '/contents/content/' ); ?>

            <?php echo $this->Html->link('Photos', '/uploads/images/' ); ?>
            <?php echo $this->Html->link('Companies', '/companies/mine/' ); ?>
            <?php echo $this->Html->link('Connect', '/oauth/connect/' ); ?>
        </div>
        
        <div class="banner-sub-navigation">
        <?php
        
            switch($this->request->params['controller']){
                case 'contents';
                    echo $this->Auth->link('Contents-blog_create', 'Blog', '/contents/blog_create/');
                    echo ' / ';
                    echo $this->Auth->link('Contents-post_create', 'Post', '/contents/post_create/');
                break;     
            }
            
        ?>
        </div>
        
    </div>
    <div id="BannerRight"></div>
</div>
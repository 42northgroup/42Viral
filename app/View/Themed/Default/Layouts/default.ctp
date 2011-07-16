<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>

    <?php //echo View::getVar('canonical_for_layout'); ?>

    <?php
        echo $this->Html->meta('icon');
        
        echo $this->Html->css('vendors/yui');
        echo $this->Html->css('cake.stripped');
        echo $this->Html->css('default');
        
        echo $scripts_for_layout;
    ?>
</head>
    <body>
        <div id="Container">
            <?php echo $this->Session->flash(); ?>
            
            <div id="Header">

            </div>
            
            <div id="Banner" class="clearfix">
                <div id="BannerLeft">
                    <strong style="font-size: 160%; display: block; text-align: center; margin: 10px 0 0">
                        The 42Viral
                    </strong>
                    <strong style="font-size: 150%; display: block; text-align: center;">Project</strong>
                </div>
                <div id="BannerContent">The 42Viral Project</div>
                <div id="BannerRight"></div>
            </div>
            
            <div id="Wrapper" class="clearfix">
                
                <div id="Left">
                    <ul>
                        <li><a href="/pages">Pages</a></li>
                        <a href="/blogs">Blogs</a></li>
                    </ul>
                    
                    <hr />
                    <ul>
                        <li><a href="/profiles/content">Content</a></li>
                        <li><a href="/profiles/blog_create">Blog</a></li>
                        <li><a href="/profiles/post_create">Post</a></li>
                        <li><a href="/profiles/page_create">Page</a></li>
                    </ul>
                    
                    <hr />
                    <ul>
                        <li><a href="/users/login">login</a></li>
                        <li><a href="/users/logout">logout</a></li>
                        <li><a href="/profiles/view/jasonsnider">Private</a></li>
                        <li><a href="/profiles/pub/jasonsnider">Public</a></li>
                    </ul>                    
                </div>
                
                <div id="Content"><?php echo $content_for_layout; ?></div>
                
                <div id="Right">
                    test
                </div>
                
            </div>
            
            <div id="Footer"></div>
        </div> 
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
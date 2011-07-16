<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $title_for_layout; ?></title>

    <?php //echo View::getVar('canonical_for_layout'); ?>

    <?php
        echo $this->Html->meta('icon');

        //echo $this->Html->css('cake.generic');
        echo $this->Html->css('vendors/yui');

        echo $scripts_for_layout;
    ?>
    <style type="text/css">

        body{
            margin: 0 0;
        }
        
        #Header{
            height: 30px;
            background: #000;
        }
          
        #Banner{
            background: #f5f5f5;
            border-bottom: 1px solid #e5e5e5;
            height: 71px;
        }
        
        #Content,
        #BannerContent{
            width: 800px;
            float: left;
            overflow: hidden;
            padding: 0 12px 12px;
        }
        
        #BannerContent{
            text-align: center;
        }

        #Left,
        #BannerLeft{
            width: 175px; 
            float: left;
        }   
        
        #Right,
        #BannerRight{
            float: left;
        }  
        
        table{
            border-collapse: collapse;
            width: 100%;
        }
        
        td{
            border: 1px solid #E5E5E5;
            border-left: none;
            border-right: none;
        }
        
        /* The Magnificent Clearfix: Updated to prevent margin-collapsing on child elements.
           j.mp/bestclearfix */
        .clearfix:before, 
        .clearfix:after { 
            content: "\0020"; 
            display: block; 
            height: 0; 
            overflow: hidden; 
        }
        
        .clearfix:after { 
            clear: both; 
        }
        
        /* Fix clearfix: blueprintcss.lighthouseapp.com/projects/15318/tickets/5-extra-margin-padding-bottom-of-page */
        .clearfix { 
            zoom: 1; 
        }
        
        /* Flash messages*/
        #SetFlash, #flashMessage{
            text-align: center;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
        }
        #FlashError{
            background: #900;
            padding:6px;            
        }
 
        #FlashSuccess{
            background: green;
            padding:6px;            
        }
        
        #FlashError:after{
            content: ' :(';           
        }
 
        #FlashSuccess:after{
            content: ' :)';           
        }        
        
        pre,
        code{
            overflow: auto;
        }
        
        /* FORMS */
        
        /* At this level we can't worry about speocifics, only the most general of concepts */
        form{}
        
        input[type="text"],
        input[type="password"],
        select,
        textarea{
            border: 1px solid #000;
            border-radius: 2px;
            font-size:16px;
            padding: 6px;
        }
        
        label{}
        
        
        form.default{
            width: 300px;
        }
        
        form.default input[type="text"],
        form.default input[type="password"],
        form.default select,
        form.default textarea{
            border: 1px solid #000;
            border-radius: 2px;
            width: 176px;
            padding: 2px;
        }
        
        form.default label{
            display: inline-block;
            width: 106px;
            padding-right: 12px;
            text-align: right;
        }

        
        
        form.content{
            width: 100%;
        }
        
        form.content label{
            display: block;
        }
        
        form.contnet input[type="text"],
        form.contnet input[type="password"],
        form.content select,
        form.contnet textarea{}
        
        
        .submit{
            text-align:right;
        }
        
        input[type="submit"]{
            padding: 8px 12px;
            font-size: 16px;
        }
        
        
    </style>
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
# SEO Plug-in

When it comes to SEO, clean original content is 60% of the battle. There are many other best practices that will make
your SEO incrementally better. The goal of the SEO plug-in is to support these best practices without the content
producer needing to think about it. Simply write clean original content and we will take care of the rest. In addition 
to SEO, the SEO plug-in we are adding support for other common traffic driving techniques.

* Automatic slug creation and disambiguation
* Automatic canonical link creation and disambiguation
* Built in URL shortener
* Site map generator 

## Basic Usage

`SeoBehavior` expects a title column. If your table has one, you may simply add the following to your model

    public $actsAs = array(
        'Seo.Seo'
    );

Otherwise you may use the "convert" setting against a given column, for example if name is the equivalent of title

    public $actsAs = array(
        'Seo.Seo'=>array(
            'convert'=>'name'
        )
    );

## URL Shortener 

When content is created a short_cut value is saved to the content table. Blogs, pages and posts are set up to 
handle the URL shortener by default. To make use of the URL shortener simply create a redirect domain. In Apache you 
would do something similar to the following to send short.example.com traffic to example.com
   
    # Shorty example, forces system generated short URLs into our application
    <VirtualHost *:80>
        ServerName short.example.com
        ServerAdmin webmaster@example.com

        RedirectMatch 301 /a/(.*) http://example.com/pages/short_cut/$1
        RedirectMatch 301 /b/(.*) http://example.com/blogs/short_cut/$1
        RedirectMatch 301 /c/(.*) http://example.com/posts/short_cut/$1
    </VirtualHost>

Notice the a, b, c part of the redirect. This is how we tell our redirect which model/controller pair we want to
go to.

When using the above convention, make sure the controller/action you're specifying can handle the request. The following
will do an SEO safe redirect against blog content.

    /**
     * Redirect short links to their proper url
     * @param string $shortCut 
     * @return void
     */
    public function short_cut($shortCut) {

        $blog = $this->Blog->fetchBlogWith($shortCut, 'nothing');

        //Avoid Google duplication penalties by using a 301 redirect
        $this->redirect($blog['Blog']['canonical'], 301);
    }  

## Site Map

Site map data is created as part of creating and managing content. Since we have no idea how big any one site may
become, we have pushed the creation of this data to a shell. To generate a new site map navigate to your app directory
and run

    Console/cake sitemap

This will create a new site map at `webroot/sitemap.xml`. Be sure you have proper permissions for overwriting this file.
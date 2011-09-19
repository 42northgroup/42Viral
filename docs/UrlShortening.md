# URL Shortening

The content table comes pre-loaded with short_cut column. By default this is a 4 character random string of  numbers and 
lower case letters (gives ~1.6 million combinations per content type). To use this find a very short domain name. 
42Viral.com uses 42v.us; we've configured this to do nothing but redirect. Say we have blog post titled "How to use the 
URL Shortner", we would expect the following link; https://42viral.com/post/how-to-use-the-url-shortner. However, a 
short_cut is always created when we create new content. Let's say the short cut for the post is qwer, since our page is 
returned via a $token which looks for either $slug or $short_cut https://42viral.com/post/qwer and 
https://42viral.com/post/how-to-use-the-url-shortner will resolve the same content. When used with our Short domain name 
the new URL would read as http://42v.us/c/qwer where "/c/" is how we target posts, so we would then redirect to 
https://42viral.com/post/qwer. We place the redirects in our vhosts file.

    <VirtualHost *:80>
        ServerName 42v.us
        ServerAdmin jason.snider@42v.us

        ## We will use single letters to target the content types

        ## Redirect pages
        RedirectMatch 301 /a/(.*) https://42viral.com/page/short_cut/$1

        ## Redirect blogs
        RedirectMatch 301 /b/(.*) https://42viral.com/blog/short_cut$1

        ## Redirect posts
        RedirectMatch 301 /c/(.*) https://42viral.com/post/short_cut/$1
    </VirtualHost>

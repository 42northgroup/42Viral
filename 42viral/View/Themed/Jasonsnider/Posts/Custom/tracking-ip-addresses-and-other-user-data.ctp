<!--Jason Snider 10/18/2008-->

<p>
Tracking information about your user such as how they got to your site
(directly, a search engine, referral link etc) is a critical piece in gathering
the needed data to properly analyze your traffic. This data can help you make
better decisions to help improve your overall user experience. Today I'll show
you how to get the data. Later we will discuss how to build some simple reports.
</p>

<h2>Your IP Address</h2>

<p><b><?php echo $_SERVER['REMOTE_ADDR']; ?></b></p>

<p>
On the surface this may not seem very useful, but it does have value. First
this enables you to remove data about you hitting your own page. This will
give you a view of just you visitors. Another great use is matching duplicate
IPs. Unique IPs and Repeating IPs are to very different sets of data.
</p>

<h2>Host Details (Your ISP)</h2>

<p><b><?php echo gethostbyaddr($_SERVER['REMOTE_ADDR']); ?></b></p>

<p>This let's us know who our users ISP is. I really haven't much of a use
for this, but I could see where some may find it useful.
</p>

<h2>Browser Details</h2>
<p><b><?php echo $_SERVER['HTTP_USER_AGENT']; ?></b></p>

<p>This is very valuable. Personally I build to W3C standards and get it
working in those browsers (FireFox, Opera, Safari, etc). Then I'll make 2
copies of that style sheet ie6.css and ie7.css then get to work making those
work. In this case I use the browser details to decide which style sheet or
front end hack I need to serve up.
</p>

<p>To me, this also answers the question; Do we really need to support that
browser? IE8 will be coming out soon, this has many developers rejoicing.
"Finally we can kill IE6 support!" Not so fast. I see this killing
IE7 support before IE6 support (legacy intranet and all that). This answers
that question for you. If IE6 is still &gt;20% of your traffic. I'd say you have
to support it, &lt;5% I'd probably consider killing support for it, but not
before then.
</p>

<h2>Referrer (How you got here)</h2>
<p>
    <b>
    <?php
        if(isset($_SERVER['HTTP_REFERER'])){
            echo $_SERVER['HTTP_REFERER'];
        }else{
            echo 'Direct Hit';
        }
    ?>
    </b>
</p>

<p>This tells us how the user got here. This is great for tracking ad
campaigns, referrer links, and your traffics origin in general. By analyzing
the urls from search engines you can even determine the key words used to
find your site.
</p>

<pre><code>&lt;?php<br>/* Let's start with an array to hold the user data */<br>$you = array();<br>/*PHP does most of the work for us. We just need to reference the predefined functions and variables.*/<br>$you['ip'] = $_SERVER['REMOTE_ADDR'];<br>$you['hostaddress'] = gethostbyaddr($you['ip']);<br>$you['browser'] = $_SERVER['HTTP_USER_AGENT'];<br>$you['referer'] = $_SERVER['HTTP_REFERER'];<br>?&gt;<br><br>&lt;!--Now that we have the user data let's loop the array and display the data --&gt;<br>&lt;?php foreach($you as $key =&gt; $value): ?&gt;<br>&lt;strong&gt;&lt;?php echo $key; ?&gt;&lt;/strong&gt;&lt;br /&gt;<br>&lt;p&gt;&lt;?php echo $value; ?&gt;&lt;/p&gt;<br>&lt;?php endforeach; ?&gt;<br></code></pre>
<p>The next article in this series will discuss
<a href="/post/building-traffic-reports">building traffic reports</a>
</p>
<div class="external-links">
<h2>External Links</h2>
    <ul>
        <li><a href="http://php.net/manual/en/reserved.variables.server.php">$_SERVER</a></li>
        <li><a href="http://php.net/manual/en/function.gethostbyaddr.php">gethostbyaddr()</a></li>
    </ul>
</div>
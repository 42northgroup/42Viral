<p>
As a web developer I have found there are three things I cannot live without.
The LAMP stack, Adobe and IE6. I know what your probably thinking. There are Linux
alternatives to Adobe and IE6 is an old legacy browser, why worry about it? I
will not argue either point as they are both valid. Those points aside I need to be
interoperable with the real world.
</p>

<p>
By trade I'm a programmer, not a designer while as a programmer I can happily
live in the LAMP stack and never leave, however, the end product (your website)
needs to be sexy. Making it sexy is a designers job and designers (atleast the ones
I know) live in Adobe. This probably means I'll need to take a proprietary Adobe
format (typically .psd) slice it and/or extract the elements I need and convert
them to the final web format. To make this possible I need Adobe. So, what's the
rational behind IE6? Three things actually. First, IE6 still has a 30% market
share making it the number one browser currently in use. Second, a quick check of
Google Analytics and I see IE6 is still accounts for nearly 25% of my site traffic
(This I cannot ignore), and finally.Microsoft recently announced they are going
to be supporting IE6 until 2014. Taking these facts into account, as a developer,
failing to test for IE6 compatibility means I have failed in both prudence and
diligence.
</p>

<h2>My Environment</h2>
<p>My full development environemnt consists of Linux servers, a Linux environment
for development and Windows enviroments for graphics and testing</p>

<strong>Optimal recommended hardware specs</strong>
<p>These may vary a bit, but these are my laptop specs which handles multiple
multiple confiurations and multiple VM's running at once.</p>
<ul>
    <li>2.13ghz Intel Core DUO</li>
    <li>4gb RAM</li>
    <li>512mb Nvida GForce 9600</li>
</ul>

<strong>Minimal recommended hardware specs</strong>
<p>If your running any version of AdobeCS I reccomend using Windows as the host
system and suspending any guests prior to entering AdobeCS.</p>
<ul>
    <li>1.8 ghz AMD Turion64</li>
    <li>2gb RAM</li>
    <li>128mb ATI</li>
    <li>Operating Systems</li>
</ul>
<strong>Recommended Operating Systems</strong>
<p>Currently Windows 7 RC is acts as my host, I'll likely get board with that
setup and switch to something else. Any of the follwing are not only needed
for proper development and testing, they will all work fine as your host OS</p>
<ul>
    <li>Debian 4 Linux (My production servers run Debian 4 so this is a good choice
    for testing)</li>
    <li>Ubuntu 9.04 Linux (Ubuntu is based on Debian and has the same server stack.
    Ubuntu's a bit more user friendly so I like to run my development enviroment here)</li>
    <li>Windows XP Home or Professional (Required for testing in IE6, IE7 and IE8
    and this may serve as your AdobeCS host)</li>
    <li>Windows 7 (I'm using an RC at the time of this post. Use for testing IE8 and
    to host your AdobeCS apps)</li>
</ul>
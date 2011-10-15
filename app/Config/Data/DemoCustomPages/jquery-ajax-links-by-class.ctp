<?php
/**
 * JAWS lite (JAson's Web Site)
 * Licensed under The MIT License
 *
 * Returns some information to the usser about who they are
 *
 * Copyright (c) 2010 Jason D Snider. All rights reserved
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Jason D Snider 2010. All rights reserved.
 * @link          http://jasonsnider.com
 ** @author        Jason D Snider
 * @version       2010-04-03
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

$_HEADTITLE = <<<EOF
JQuery AJAX links by class
EOF;

$_PAGETITLE = <<<EOF
JQuery AJAX links by class
EOF;

$_TAGLINE =<<<EOF
 Ajaxify your hyperlinks with fallback.
EOF;

$_DESCRIPTION = <<<EOF
A tutorial showing how to build AJAX links with fallback using JQuery
EOF;

$_KEYWORDS = <<<EOF
AJAX, JQuery, Tutorial
EOF;

$_INTRO = <<<EOF
    <p>
    In my opinion JQuery is among the best JavaScript frameworks available today.
    JQuery is lightweight, robust and easy to use. JQuery assures easy to implement
    AJAX functionality with crosbrowser compatability back to IE6. In this tutorial
    we will discuss an easy way to AJAX-ify all links of a target class while
    maintaing fallback for browsers lacking JavaScript support.
    </p>
EOF;

$codeblock = htmlentities("<div id=\"AjaxBlock\">Look at me!</div>");

$codeblock1 = htmlentities("<head>").'<br />';
$codeblock1 .= htmlentities("<!--Other Header Content Here-->").'<br />';
$codeblock1 .= htmlentities("<script type=\"text/javascript\" src=\"/jquery-1.3.2.min.js\"></script>").'<br />';
$codeblock1 .= htmlentities("</head>");

$codeblock2 = htmlentities("\t<head>").'<br />';
$codeblock2 .= htmlentities("\t\t<script type=\"text/javascript\" src=\"/js/jquery-1.3.2.min.js\"></script>").'<br />';
$codeblock2 .= htmlentities("\t\t<script type=\"text/javascript\">").'<br />';
$codeblock2 .= htmlentities("\t\t\t$(document).ready(function(){").'<br />';
$codeblock2 .= htmlentities("\t\t\t\t$('.ajax-link').click(function(){").'<br />';
$codeblock2 .= htmlentities("\t\t\t\t\tvar href = $(this).attr('href') + '?request=ajax'; //Get the target URL").'<br />';
$codeblock2 .= htmlentities("\t\t\t\t\t$('#AjaxBlock').load(href); //Create the xmlHttpRequest").'<br />';
$codeblock2 .= htmlentities("\t\t\t\t\treturn false; //Stop the HTTP request").'<br />';
$codeblock2 .= htmlentities("\t\t\t\t});").'<br />';
$codeblock2 .= htmlentities("\t\t\t});").'<br />';
$codeblock2 .= htmlentities("\t\t</script>").'<br />';
$codeblock2 .= htmlentities("\t</head>").'<br />';
$codeblock2 .= htmlentities("\t<body>").'<br />';
$codeblock2 .= htmlentities("\t\t<h1>JQuery Ajax Links by Class Demo</h1>").'<br />';
$codeblock2 .= htmlentities("\t\t<div id=\"AjaxBlock\">Look at me!!</div>").'<br />';
$codeblock2 .= htmlentities("\t\t<a href=\"test.php\" class=\"ajax-link\">Today's Date Ajax</a><br />").'<br />';
$codeblock2 .= htmlentities("\t\t<a href=\"test1.php\" class=\"ajax-link\">Tomarrow's Date Ajax</a><br />").'<br />';
$codeblock2 .= htmlentities("\t\t<a href=\"test1.php\">Today's Date Postback</a><br />").'<br />';
$codeblock2 .= htmlentities("\t\t<a href=\"test1.php\">Tomarrow's Date Postback</a><br />").'<br />';
$codeblock2 .= htmlentities("\t\t<div style=\"margin:40px 0\">Demo powered by <a href=\"/\">jasonsnider.com</a></div>").'<br />';
$codeblock2 .= htmlentities("\t</body>").'<br />';

$codeblock3 = htmlentities("\$('#AjaxBlock').load(href); //Create the xmlHttpRequest").'<br />';

$codeblock4 = htmlentities("\$('#AjaxBlock').load(href + '?request=ajax'); //Create the xmlHttpRequest").'<br />';

$codeblock5 = htmlentities("<html>").'<br />';
$codeblock5 .= htmlentities("\t<head>").'<br />';
$codeblock5 .= htmlentities("\t\t<script type=\"text/javascript\" src=\"/js/jquery-1.3.2.min.js\"></script>").'<br />';
$codeblock5 .= htmlentities("\t\t<script type=\"text/javascript\">").'<br />';
$codeblock5 .= htmlentities("\t\t\t$(document).ready(function(){").'<br />';
$codeblock5 .= htmlentities("\t\t\t\t$('.ajax-link').click(function(){").'<br />';
$codeblock5 .= htmlentities("\t\t\t\t\tvar href = $(this).attr('href') + '?request=ajax'; //Get the target URL").'<br />';
$codeblock5 .= htmlentities("\t\t\t\t\t$('#AjaxBlock').load(href); //Create the xmlHttpRequest").'<br />';
$codeblock5 .= htmlentities("\t\t\t\t\treturn false; //Stop the HTTP request").'<br />';
$codeblock5 .= htmlentities("\t\t\t\t});").'<br />';
$codeblock5 .= htmlentities("\t\t\t});").'<br />';
$codeblock5 .= htmlentities("\t\t</script>").'<br />';
$codeblock5 .= htmlentities("\t</head>").'<br />';
$codeblock5 .= htmlentities("\t<body>").'<br />';
$codeblock5 .= htmlentities("\t\t<h1>JQuery Ajax Links by Class Demo</h1>").'<br />';
$codeblock5 .= htmlentities("\t\t<div id=\"AjaxBlock\">Look at me!!</div>").'<br />';
$codeblock5 .= htmlentities("\t\t<a href=\"test.php\" class=\"ajax-link\">Today's Date Ajax</a><br />").'<br />';
$codeblock5 .= htmlentities("\t\t<a href=\"test1.php\" class=\"ajax-link\">Tomarrow's Date Ajax</a><br />").'<br />';
$codeblock5 .= htmlentities("\t\t<a href=\"test1.php\">Today's Date Postback</a><br />").'<br />';
$codeblock5 .= htmlentities("\t\t<a href=\"test1.php\">Tomarrow's Date Postback</a><br />").'<br />';
$codeblock5 .= htmlentities("\t\t<div style=\"margin:40px 0\">Demo powered by <a href=\"/\">jasonsnider.com</a></div>").'<br />';
$codeblock5 .= htmlentities("\t</body>").'<br />';
$codeblock5 .= htmlentities("</html>").'<br />';

$codeblock6 = htmlentities("<?php").'<br />';
$codeblock6 .= htmlentities("echo isset(\$_GET['request'])?\"<h1>Today's Date</h1>\":\"\";").'<br />';
$codeblock6 .= htmlentities("echo \"Today is  \".date('m/d/y');").'<br />';
$codeblock6 .= htmlentities("?>").'<br />';

$codeblock7 = htmlentities("<?php").'<br />';
$codeblock7 .= htmlentities("echo isset(\$_GET['request'])?\"<h1>Tomarrow's Date</h1>\":\"\";").'<br />';
$codeblock7 .= htmlentities("echo \"Tomarrow is  \".date('m/d/y',(time() + 24 * 60 * 60));").'<br />';
$codeblock7 .= htmlentities("?>").'<br />';

$_BODY = <<<EOF
<h1>JQuery AJAX Links by Class</h1>
    <p>
    In my opinion JQuery is among the best JavaScript frameworks available today.
    JQuery is lightweight, robust and easy to use. JQuery assures easy to implement
    AJAX functionality with crosbrowser compatability back to IE6. In this tutorial
    we will discuss an easy way to AJAX-ify all links of a target class while
    maintaing fallback for browsers lacking JavaScript support.
    </p>

    <p>
    Before we write our first line of code we need know what we are writing. Let's
    start by defining the problems to solve.
    </p>

    <h2>Problems</h2>
    <ol>
        <li>We want to be able to quickly load new contents on to a webpage with
        out the overhead of reloading the entire page.</li>
        <li>We want to have multiple links, each of which loads a differnt set
        of data.</li>
        <li>We do not a clients a client lacking JavaScript to have a bad experiance.</li>
        <li>We are lazy programmers, we want to write less code.</li>
    </ol>

    <h2>Solutions</h2>
    <ol>
        <li>Implement AJAX</li>
        <li>Clicking a link will result in an xmlHttpRequest instead of a postback</li>
        <li>Write functional HTML and override it with JavaScript. This means a
        lack of JavaScript would fallback to traditional HTML</li>
        <li>Using JQuery, we will define a css class just for AJAX links. This
        will allow us to "group" the AJAX calls</li>
    </ol>
    </p>

    <p>
    First, we need to target an element in which to load our AJAX content. We'll
    use a div with an id of AjaxBlock. We will preload the div with the text,
    "Look at me!".
    </p>
    <pre><code>{$codeblock}</code></pre>

    <p>
    Next, we'll need to add JQuery to our webpage. Go to jquery.com and download
    the latest version of jquery (currently 1.4.2, this demo will use 1.3.2.min).
    And place a reference to it in the head section of your webpage.
    </p>
    <pre><code>{$codeblock1}</code></pre>

    <p>
    Now, we need to write some code. We'll define a class called ajax-link and
    bind an event listener to it. The listner will wait for an onclick event to
    occur on any element with the ajax-link class. We will only want to apply this
    to an element that can accept an href attribute suah as an anchor tag). When
    the onclick event is detected we will parse the element and store it's href
    value. We will then use that href value to make an xmlHttpRequest. The results
    of this request will get loaded into the div specified by the load call. In
    this case AjaxBlock. Finally, we will return false against the postback, thus
    breaking the anchor tags native functionality. In short, we are highjacking
    the postback and replacing it with an xmlHttpRequest.
    </p>

    <pre><code>{$codeblock2}</code></pre>

    <p>
    Notice the link to test.php. This is simply a .php file that returns the
    data we want to load into the div. In most cases we just want to load some
    kind of media into a div. However, in this case we must consider fallback.
    Since our goal one of our goals is fallback we must consider what will happen
    when we fallback. Appending a \$_GET parameter to the AJAX load function
    can help us to identify if we are making an xmlHttpRequest or a post back.
    </p>

    <p>Before fallback consideration</p>
    <pre><code>{$codeblock3}</code></pre>

    <p>After fallback consideration</p>
    <pre><code>{$codeblock4}</code></pre>

    <p>test.php</p>
    <pre><code>{$codeblock6}</code></pre>

    <p>test1.php</p>
    <pre><code>{$codeblock7}</code></pre>

    <!--<a href="/portals/code/jquery-ajax-links-by-class.txt" target="_blank">Plain Text</a>-->
    <pre><code>{$codeblock5}</code></pre>

<!--
    <div>
        <a href="/demos/2010/04/jquery-ajax-links-by-class.php" target="_blank">Demo</a>&nbsp;|&nbsp;
        <a href="/portals/code/jquery-ajax-links-by-class.txt" target="_blank">Full Source Codes</a>
    </div>
-->
EOF;

$_PUBDATE = <<<EOF
04/29/2010
EOF;

$_BLOG_ID = '2010-04-29a';

echo $_BODY;

?>

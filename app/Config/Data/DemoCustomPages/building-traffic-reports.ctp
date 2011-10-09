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
 * @author        Jason D Snider
 * @version       2010-04-03
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */


$_DESCRIPTION = <<<EOF
Who is comming to your website. How to build reports about your websites traffic.
EOF;

$_KEYWORDS = <<<EOF
reports, traffic, users
EOF;

$you = array();
$you['ip'] = $_SERVER['REMOTE_ADDR'];
$you['hostaddress'] = gethostbyaddr($you['ip']);
$you['browser'] = $_SERVER['HTTP_USER_AGENT'];
$you['referer'] = $_SERVER['HTTP_REFERER'];

$_INTRO = <<<EOF
    <p>
     Now that we know how to get user data we need to do something with it.
    </p>
EOF;
$codeblock1="\$you = array();"."<br />";
$codeblock1.="\$you['ip'] = \$_SERVER['REMOTE_ADDR'];"."<br />";
$codeblock1.="\$you['hostaddress'] = gethostbyaddr(\$you['ip']);"."<br />";
$codeblock1.="\$you['browser'] = \$_SERVER['HTTP_USER_AGENT'];"."<br />";
$codeblock1.="\$you['referer'] = \$_SERVER['HTTP_REFERER'];"."<br /><br />";
$codeblock1.="mysql_connect(\$server, \$username, \$password);<br />";
$codeblock1.="mysql_select_db('traffic');<br />";
$codeblock1.="mysql_query(\"INSERT INTO visitors ip='{\$you['ip']}', hostaddress='{\$you['hostaddress']}', browser='{\$you['browser']}', referer='{\$you['referer']}'\");<br />";

$codeblock2="echo ".htmlentities('"<table>";')."<br />";
$codeblock2.="while(\$results = mysql_fetch_object(mysql_query('SELECT * FROM visitors ORDER id DESC'))){<br />";
$codeblock2.="echo ".htmlentities('"<tr>";')."<br />";
$codeblock2.="echo ".htmlentities('"<td>{$results->ip}</td>";')."<br />";
$codeblock2.="echo ".htmlentities('"<td>{$results->hostaddress}</td>";')."<br />";
$codeblock2.="echo ".htmlentities('"<td>{$results->browser}</td>";')."<br />";
$codeblock2.="echo ".htmlentities('"<td>{$results->referer}</td>";')."<br />";
$codeblock2.="echo ".htmlentities('"</tr>";')."<br />";
$codeblock2.="}<br />";
$codeblock2.="echo ".htmlentities('"</table>";')."<br />";
$codeblock2.="EOF;";

$_BODY = <<<EOF
    <p>
     Yesterday, in my <a href="/posts/ip-address-and-other-user-data">
     article about tracking user data</a> we talked about how to access and store
     data about your web sites traffic. Today we will discuss how to use it.
    </p>

    <p>
    To make our traffic report we need to collect, store and retrive the data about
    each of our users. For this example we'll use MySQL as our data store. We start
    by establishing a connection to a databse named traffic then using the array
    we built yesterday save the user data to the vistors table.
    </p>

    <pre><code>{$codeblock1}</code></pre>

    <p>
    Now that we have saved some data we need to run some reports. The first
    example will return a simple log of all the users activity.
    </p>

    <pre><code>{$codeblock2}</code></pre>

    <p>At this point you should have a table similar to the following.</p>
    <div style="overflow:auto; white-space:nowrap;">
    <table border=1>
    <tr><th>IP</th><th>Host</th><th>Referer</th><th>Browser</th></tr>
    <tr>
    <td>68.23.43.88</td>
    <td>c-98-227-118-217.hsd1.il.comcast.net</td>
    <td>http://www.jasonsnider.com/posts/2009/08/multiplatform-development-and-testing</td>
    <td>Mozilla/5.0 (X11; U; Linux i686; en-US) AppleWebKit/533.2 (KHTML, like Gecko) Chrome/5.0.342.9 Safari/533.2</td>
    </tr>
    </table>
    </div>
    <p>
    That's it, we now have a simple log file of our websites traffic. Later we'll
    discuss a more detailed analysis of your sites traffic.</p>
    </p>
    <strong>The Full Source Code</strong><br />
    <a href="/portals/code/building-traffic-reports.txt" target="_blank">Plain Text</a>
    <pre><code>{$codeblock1}<br />{$codeblock2}</code></pre>
EOF;

$_PUBDATE = <<<EOF
10/19/2008
EOF;

$_BLOG_ID = '2008-10-19a';
echo $_BODY;
?>

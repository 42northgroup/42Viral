<p>When working in a Debian based system, apt-get is a great utility for installing packages and programs. phpMyAdmin one of my favorite tools for dealing with a MySQL database. Naturally, I install phpMyAdmin  using apt-get. Depending on the version of your Debian based OS or anything that may have gone wrong during install; how you go about accessing phpMyAdmin isn't always so clear.</p>

<p><i>Assumes a Debian based Linux distro and Apache2.</i></p>

<p>In a perfect world you would simply run the following command.</p>

<pre><code>apt-get install phpmyadmin</code></pre>

<p>Then simply go to http://localhost/phpmyadmin and there it is. But this isn't always the case. Typically when this fails it's because Apache doesn't know about phpMyAdmin. The solution is simple, just tell Apache about phpMyAdmin.</p>

<p>To tell Apache about phpMyadmin open a terminal window and enter the following.</p>

<pre><code>vim /etc/apache2/apache2.conf</code></pre>

<p>Replace "vim" with your editor of choice. At the bottom of your apache2.conf file enter the following line. </p>

<pre><code>Include /etc/phpmyadmin/apache.conf</code></pre>

<p>Restart Apache</p>

<pre><code>/etc/init.d/apache2 restart</code></pre>

<p>Then simply go to http://localhost/phpmyadmin and there it is. Of course, if your not running this locally, replace localhost with any domain name on your server.</p>
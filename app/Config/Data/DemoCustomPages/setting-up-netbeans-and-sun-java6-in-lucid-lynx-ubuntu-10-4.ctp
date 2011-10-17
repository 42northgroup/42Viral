<p>As a geek I'm always picking up different tools and weighing them against my current method of doing things. As a web developer my integrated development environment (IDE) is a critical piece of my day. Traditionally, I've used <a href="http://www.eclipse.org/" target="_blank">Eclipse</a> but over the last few months I've moved to <a href="http://netbeans.org/">Netbeans</a>. From a performance and usability standpoint it just feels a bit snappier and the language integration seems just a little tighter. It has great native support for PHP, Ruby on Rails and I've even heard talk of a CakePHP plugin so most of my day to day stuff is covered.</p>

<p>While the Netbeans install is fairly straight forward, installing the Sun Java6 JDK on Ubuntu 10.4 isn't so well documented. So I thought I would take a few minutes and share the installation process that works best for me.</p>

<p>First, we'll open a terminal and use apt-get for the Java install. We'll start by updating the repository.</p>
<pre>
<code>
sudo add-apt-repository "deb http://archive.canonical.com/ lucid partner"
sudo apt-get update
</code>
</pre>


<p>Second, we'll install the Sun Java6 JDK by calling the sun-java6-jdk package. <em>Use tab and the space bar to accept the prompts.</em></p>

<pre>
<code>
sudo apt-get install sun-java6-jdk
</code>
</pre>


<p>Next, we'll need to grab the Netbeans package. We'll use wget to do this.</p>
<pre>
<code>
wget http://download.netbeans.org/netbeans/6.9.1/final/bundles/netbeans-6.9.1-ml-linux.sh    
</code>
</pre>


<p>Finally, we'll install Netbeans. Let's start by making the install file executable, then run the install script.</p>
<pre>
<code>
chmod +x netbeans-6.9.1-ml-linux.sh
./netbeans-6.9.1-ml-linux.sh
</code>
</pre>
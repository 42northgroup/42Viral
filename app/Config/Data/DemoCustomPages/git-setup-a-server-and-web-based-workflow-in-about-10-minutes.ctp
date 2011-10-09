<p>
Early on in my career I tracked my code changes using a text editor then pushed those changes over FTP, I knew there had to be a better way. Eventually, I was introduced to concurrent version system (CVS). While this did automate the tracking process and brought some since of sanity to team coding efforts, it still didn't quite feel right. SVN seemed a popular choice but I saw no real value in switching over, then along came Git. Almost the very minute I started playing with Git I knew I had a winner. This is everything version control should be. I knew instantly I should be using Git however, the question did remain; how?
</p>
<p>
It's not just enoguh to say, "Yes, this is a superior version control system, we must use it.". It needs to be able to work with you, without getting in the way. As web developer I need to be able to push from my dev machines into testing and procduction environments and it needs to be seemless. The process should be something like change code, push to repository, pull from respository and new code is live. Once we have determined Git can accomadate the desired workflow (and it can) we'll need to get started with the set up. If your new to Git I would suggest first reading the documentation. If your eager to get started they have a quick and dirty tutorial to Git you going. I know Git can feel a little over whelming at first, but don't worry; we can map out the the workflow, install Git and have the Git server (the repository) up and running in about 10 minutes.
</p>

<h2>The tutorial</h2>
<p>
I'm assuming you've just got your web server up and running and now, your ready to deal with version control. We'll assume you'll be building a web site for example.com. This tutorial will walk you through the steps I used to set up a git server andweb based workflow on Debian 5 (Lenny) Linux. First open a shell. Via the shell, login to your server, install git , and create a git user (for this tutorial we'll just call the user git).
<br><em>Replace xxx.xxx.xxx.xxx with your server's IP address.</em>
</p>
<pre>
<code>
ssh root@xxx.xxx.xxx.xxx
apt-get install git-core
sudo adduser git
exit
</code>
</pre>

<p>
Logout of your root account and login as your git user. Create a directory for your project (example.git), switch to your new directory and initialize the directory as a git repository. Then logout as the git user.
</p>
<pre><code>
ssh git@xxx.xxx.xxx.xxx
mkdir example.git &amp;&amp; cd example.git
git --bare init
exit
</code>
</pre>

<p>On your development machine create a path to the local copy of your website. Next, initialize the sites root directory as a git directory. Then, you'll want to create an empty README file to give us something to push. At this point, we are ready to stage and commit our README file. Once committed, we'll add a remote, this will allow us to push and pull by calling origin. Finally, we will push to origin.</p>

<pre><code>
cd /var/www/vhosts/example.com/httpdocs
git init
touch README
git add README
git commit -m 'first commit'
git remote add origin git@xxx.xxx.xxx.xxx:example.git
git push origin master
</code>
</pre>

<p>Now we have our git server running and our development repository. We now need to pull our code into our production site. To do this we will initialize out production site the same way we did our local site. Login as root (or whatever user has the appropriate privileges). Switch one directory up from root and clone the git repo, giving it an alias, since I've become accustomed to PLESK based servers I'll use their path convention and clone the repository as httpdocs. Then log out as the privileged user.</p>
<pre><code>
ssh root@xxx.xxx.xxx.xxx
cd /var/www/vhosts/example.com
git clone /home/git/example.git httpdocs
exit
</code>
</pre>
<p>Now we can push and pull using just our branch names since master is the default that's we'll use. Refer to Git's documentation for more information on branches.</p>
<p>Now, we're ready to test our workflow. Navigate to your web directory and open the README file. Once open, type "testing" or some like text. Stage the changes, commit and push to origin. </p>

<pre><code>
cd /var/www/vhosts/example.com/httpdocs
vim README
git add README
git commit -m 'Testing GIT install'
git push origin master
</code>
</pre>
<p>Once again login to your server as root (or a properly privledged user). Navigate to your web directory and pull from origin.</p>
<pre><code>
ssh root@xxx.xxx.xxx.xxx
cd /var/www/vhosts/example.com/httpdocs
git pull origin master
</code>
</pre>
<p>Now, by navigating to your websites read me file (www.example.com/README), you'll now be able to see your changes on the live site.</p>

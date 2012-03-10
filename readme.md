# The 42Viral Project

A full CMS and blogging platform to provide a scalable and robust "kick start" for projects of any size.

_Be warned we are still in dev mode, anything can change with out notice nor remorse_

## Libraries and Concepts

* CakePHP
* CakePHP Search Plugin, CakeDC <http://cakedc.com/eng/downloads/view/cakephp_search_plugin>
* CakePHP Tags Plugin, CakeDC  <http://cakedc.com/downloads/view/cakephp_tags_plugin> 
* CakePHP Tags Plugin, CakeDC  <http://cakedc.com/downloads/view/cakephp_tags_plugin> 
* JasonSnider Seo Plugin <https://github.com/jasonsnider/CakePHP-Seo-Plugin>
* JasonSnider Scrub Plugin <https://github.com/jasonsnider/CakePHP-Scrub-Plugin>
* RobWilkerson AuditLog Plugin <https://github.com/robwilkerson/CakePHP-Audit-Log-Plugin>
* Lyubomir Dimov CalendarRecursion Plugin <https://github.com/ldimov/CakePHP-CalendarRecursion-Plugin>
* HTMLPurifier
* jQuery
* jQuery UI
* HTMLBOILERPLATE
* Modernizr

## Third API party support

* Gravatar (Currently only avatars)
* Disqus
* Twitter
* LinkedIn
* Facebook

## Development

Agile, Test Driven Development.

Models, Components, Helpers and Behaviors, should be responsible for everything. While the project will provide UI and 
work-flows we should be able to drop all of the controllers (except those that provide web services) and views without 
losing the ability to manage the data.

## Installation

Currently, installation is written for Ubuntu Linux. Installation on other Linux distros is pretty similar; typically 
this is a case of dropping sudo in favor using a root shell. For non-Debian derivatives you would replace apt-get 
accordingly. For Red Hat derivatives apt-get would likely be replaced with yum.

I recommend the advanced install options from the CakePHP Cookbook

add the following to you php.ini file

    include_path = '.:/usr/share/php:/usr/share/cakephp-2.0/lib'

Create the CakePHP library

    cd /usr/share
    sudo git clone https://github.com/cakephp/cakephp.git cakephp-2.0 

### Git based install

Replace 
- example.com with the name of your site
- /var/www/vhosts/ with your server path
- httpdocs with whatever you want to call it

    cd /var/www/vhosts/example.com

    ## Clone the project
    git clone git@github.com:microtrain/42Viral.git httpdocs
    cd httpdocs

    ## Pull the submodules
    git submodule init
    git submodule update

    ## Pull htmlpurifier into the ContentFilter submodule
    cd app/Plugin/ContentFilters
    git submodule init
    git submodule update

    ## Pull imagine into the Imagine submodule
    cd app/Plugin/Imagine
    git submodule init
    git submodule update

From a command line, navigate to your app directory and gain root access. (Required for setup as the script needs to 
access chown). You'll provide 2 arguments the user name that apache runs as (probably www-data) and the group that will 
have write access to the app directory (this is probably your username).

    sudo ./setup.sh www-data jasonsnider 

Open a web browser and navigate to the first run wizard.

    https://www.example.com/setup

Now we will want to build out database. Navigate to app/Console and run the schema command, but first make sure the Cake
console is writable.

    sudo chmod +x cake
    sudo ./cake schema create

This will finish setting up the application and allow you to provide credentials for your root user. 

### Debugging and testing

#### Installing PHPUnit

    sudo apt-get install php-pear
    sudo pear channel-discover pear.phpunit.de
    sudo pear channel-discover components.ez.no
    sudo pear channel-discover pear.symfony-project.com
    sudo pear install phpunit/PHPUnit
    sudo apt-get install phpunit

There seems to be a version bug in in Ubuntu 11.04, running this will force a new
version pear and fix the issue.

    sudo pear upgrade pear
    sudo pear install -a phpunit/PHPUnit

#### Installing x-debug

    sudo apt-get install php5-xdebug

    sudo vim /etc/php5/apache2/conf.d/xdebug.ini

    ; configuration for php xdebug module
    zend_extension="/usr/lib/php5/20090626/xdebug.so"
    xdebug.remote_enable=1
    xdebug.remote_handler=dbgp
    xdebug.remote_mode=req
    xdebug.remote_host=127.0.0.1
    xdebug.remote_port=9000

    sudo /etc/init.d/apache2 restart

## License ##

Copyright 2012, [Jason D Snider](https://jasonsnider.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2012<br/>
[42NorthGroup](https://42northgroup.com)<br/>
https://42northgroup.com<br/>
# The 42Viral Project

[![project status](http://stillmaintained.com/microtrain/42Viral.png)](http://stillmaintained.com/microtrain/42Viral)

A full CMS and blogging platform to provide a scalable and robust "kick start" for projects of any size.

__Be warned we are still in alpha development, things can and will change without notice or remorse__

## Credits

We strive to give credit where credit is due, if we missed something, please let us know!

### The 42viral Projects's core development team

* Jason Snider - Lead, Core Development
* Zubin Khavarian - Core Development
* Lyubomir Dimov - Core Development
* Matt Blake - Graphics

### Plugins

Though we typically fork plugins to our repository prior to modification and use, we rather give credit to the original
authors

* CakeDC Search Plugin, CakeDC <https://github.com/cakedc/search> 
* CakeDC Tags Plugin, CakeDC  <https://github.com/cakedc/tags> 
* CakeDC Migrations Plugin, CakeDC  <https://github.com/cakedc/migrations> 
* CakePHP Imagine Plugin, CakeDC  <https://github.com/cakedc/Imagine> 
* MicroTrain Technologies Connect Plugin <https://github.com/microtrain/CakePHP-Connect-Plugin>
* JasonSnider Seo Plugin <https://github.com/jasonsnider/CakePHP-Seo-Plugin>
* JasonSnider ContentFilters Plugin <https://github.com/jasonsnider/CakePHP-ContentFilters-Plugin>
* RobWilkerson AuditLog Plugin <https://github.com/robwilkerson/CakePHP-Audit-Log-Plugin>
* LyubomirDimov CalendarRecursion Plugin <https://github.com/ldimov/CakePHP-CalendarRecursion-Plugin>

### Libraries and Concepts

* [CakePHP](http://cakephp.org)
* [HTMLPurifier](http://htmlpurifier.org/)
* [Imagine](https://github.com/avalanche123/Imagine)
* [jQuery](http://jquery.com/)
* [jQuery UI](http://jqueryui.com/)
* [HTML5BOILERPLATE](http://html5boilerplate.com/)
* [Modernizr](http://www.modernizr.com/)
* [YUI](http://yuilibrary.com/yui/docs/cssreset/)

## Third API party support

* Gravatar (Currently only avatars)
* Disqus
* Twitter
* LinkedIn
* Facebook
* Google+
* Yahoo! Local
* Yelp

## Data Portability

We are working very hard to make all data as portable and as standards compliant as possible

Profile data currently supports 

* vacard
* xcard
* hcard

## Development

Agile, Test Driven Development.

Models, Components, Helpers and Behaviors, should be responsible for everything. While the project will provide UI and 
work-flows we should be able to drop all of the controllers (except those that provide web services) and views without 
losing the ability to manage the data.

## Installation

_As we are still in alpha development, these install instructions are written for core development_

Currently, installation is written for Apache2 on Ubuntu Linux.  

### Git based install

#### Add the CakePHP library

I recommend the advanced install options from the CakePHP Cookbook

add the following to you php.ini file __Be sure to update this for both your server and CLI .ini files__

    include_path = '.:/usr/share/php:/usr/share/cakephp-2.0/lib'

Install CakePHP in the usr/share directory

    cd /usr/share
    sudo git clone https://github.com/cakephp/cakephp.git cakephp-2.0 
    
Replace 

* example.com with the name of your site
* /var/www/vhosts/ with your server path
* httpdocs with whatever you want to call it

__app is highly recommended, by default CakePHP will always look for the app directory__

    cd /[path/to/your-site.com/httpdocs]/app

#### Clone the project

Assuming your installing the 42viral application into a directory called app

    git clone git@github.com:microtrain/42Viral.git app
    cd app
    git submodule update --recursive --init

From a command line, navigate to your app directory and gain root access. (Required for setup as the script needs to 
access chown). You'll provide 2 arguments the user name that apache runs as (probably www-data) and the group that will 
have write access to the app directory (this is probably your username).

    sudo ./setup.sh [www-data] [production] 

Open a web browser and navigate to the first run wizard.

    https://www.example.com/install.php

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

Copyright 2012, [42NorthGroup](https://42northgroup.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2012<br/>
[42NorthGroup](https://42northgroup.com)<br/>
https://42northgroup.com<br/>
# The 42Viral Project

A full CMS and blogging platform to provide a scalable and robust "kick start" for projects of any size.

## Third Party Support

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

# Installation

_As we are still in alpha development, these install instructions are written for core development_

Currently, installation is written for Apache2 on Ubuntu Linux.

## Git based install

### Add the CakePHP library

We recommend the advanced install options from the CakePHP Cookbook.

Add the following to you php.ini file __Be sure to update this for both your server and CLI .ini files__

    include_path = '.:/usr/share/php:/usr/share/cakephp-2.1/lib'

Install CakePHP in the usr/share directory

    cd /usr/share
    sudo git clone https://github.com/cakephp/cakephp.git cakephp-2.1

Replace

* example.com with the name of your site
* /var/www/vhosts/ with your server path
* httpdocs with whatever you want to call it

__app is highly recommended, by default CakePHP will always look for the app directory__

    cd /[path/to/your-site.com/httpdocs]/app

### Clone the project

Assuming you are installing the 42viral application into a directory called app:

    git clone git@github.com:42northgroup/42Viral.git app

The git repository for 42Viral consists of several git submodules which are mostly Plugins and are separate projects
hosted on GitHub. You need to make sure you obtain all the submodules using the following command:

    cd app
    git submodule update --recursive --init

From a command line, navigate to your app directory and gain root access. (Required for setup as the script needs to
access chown). You'll provide 2 arguments the user name that apache runs as (probably www-data) and the group that will
have write access to the app directory (this is probably your username).

    sudo ./Console/cake setup [www-data] [production]

The setup shell is an interactive tool which enables you to quickly setup your application's essential configuration.

You can use the option "0" when you are setting your application for the first time. This will automatically run all
the setup steps in sequence.

You can also use the setup shell after the first setup to perform individual operations such as re-configuring the
database parameters, clearing model cache, etc.

### Development Environment 

This section will provide additional details for setting up a full development environment

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

## Credits

We strive to give credit where credit is due, if we missed something, please let us know!

### The 42viral Projects's core development team

* [Jason Snider](https://github.com/jasonsnider) - Core Development
* [Lyubomir Dimov](https://github.com/ldimov) - Core Development
* [James Rohacik](https://github.com/) - Core Development
* [Zubin Khavarian](https://github.com/zubinkhavarian) - Core Development
* [Matt Blake](https://github.com/Mblake79) - Graphics

### Plug-ins

Though we typically fork plug-ins to our repository prior to modification and use, we rather give credit to the original
authors

* CakeDC [Search Plug-in, CakeDC](https://github.com/cakedc/search)
* CakeDC [Tags Plug-in, CakeDC](https://github.com/cakedc/tags)
* CakeDC [Migrations Plug-in, CakeDC](https://github.com/cakedc/migrations)
* MicroTrain Technologies [Connect Plug-in](https://github.com/42northgroup/CakePHP-Connect-Plugin)
* Jason Snider [Seo Plug-in](https://github.com/jasonsnider/CakePHP-Seo-Plugin)
* Jason Snider [ContentFilters Plug-in](https://github.com/jasonsnider/CakePHP-ContentFilters-Plugin)
* Rob Wilkerson [AuditLog Plug-in](https://github.com/robwilkerson/CakePHP-Audit-Log-Plugin)

### Libraries and Concepts

* [CakePHP](http://cakephp.org/)
* [HTMLPurifier](http://htmlpurifier.org/)
* [Imagine](https://github.com/avalanche123/Imagine/)
* [jQuery](http://jquery.com/)
* [jQuery UI](http://jqueryui.com/)
* [HTML5 Boilerplate](http://html5boilerplate.com/)
* [Modernizr](http://www.modernizr.com/)
* [YUI CSS](http://yuilibrary.com/yui/css/)
* [YUT Compressor](http://developer.yahoo.com/yui/compressor/)
* [Skeleton](http://www.getskeleton.com/)
* [Google Webfonts](http://www.google.com/webfonts/)
* [Google Closure](https://developers.google.com/closure/)

## License

Copyright 2012, [42NorthGroup](https://42northgroup.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)

Redistributions of files must retain the above copyright notice.

## Copyright

Copyright 2012 [42NorthGroup](https://42northgroup.com)

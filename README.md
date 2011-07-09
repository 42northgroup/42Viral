The 42Viral Project
===================

Goals
-----

Provide a scalable and robust "kick start" for projects of any size.


Libraries and Concepts
----------------------

* CakePHP
* HTMLPurifier
* jQuery
* jQuery UI
* HTMLBOILERPLATE
* Modernizr

Development
-----------

Agile, Test Driven Development.

Models, Components, Helpers and Behaviors, should be responsible for everything. While the project will provide UI and 
work-flows we should be able to drop all of the controllers (except those that provide web services) and views without 
losing the ability to manage the data.

#Configuration  

Any file containing configuration variables should be added to the .gitignore file. The current "Configuration" files 
are as follows:

* app/Config/core.php
* app/Config/database.php
* app/Config/email.php

Once ignored we need to put a ".default" in place:

* app/Config/core.php.default
* app/Config/database.php.default
* app/Config/email.php.default

Installation
------------

#Installing PHPUnit

# Ubuntu Linux

    sudo apt-get install php-pear
    sudo pear channel-discover pear.phpunit.de
    sudo pear channel-discover components.ez.no
    sudo pear channel-discover pear.symfony-project.com
    sudo pear install phpunit/PHPUnit
    sudo apt-get install phpunit

## Ubuntu 11-4

There seems to bea version bugin in Ubuntu 11.04, running this will force a new
version pear and fix the issue.

    sudo pear upgrade pear
    sudo pear install -a phpunit/PHPUnit

# Debian/GNU Linux

    su root
    apt-get install php-pear
    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit
    apt-get install phpunit

# REDHAT/FEDORA Linux

    su root
    yum install php-pear
    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit
    yum install php-unit



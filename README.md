# The 42Viral Project

## Goals

Provide a scalable and robust "kick start" for projects of any size.

## Libraries and Concepts

* CakePHP
* HTMLPurifier
* jQuery
* jQuery UI
* HTMLBOILERPLATE
* Modernizr

## Development

Agile, Test Driven Development.

Models, Components, Helpers and Behaviors, should be responsible for everything. While the project will provide UI and 
work-flows we should be able to drop all of the controllers (except those that provide web services) and views without 
losing the ability to manage the data.

## Abstract Classes

I've added an abstract layer that sits between Controller [Some]Controller and Model [Some]Model. These follow the 
naming convention of SomeAbstractController and SomeController extends SomeAbstractController. All of the core 42viral
methods, actions, etc live in the abstract models, the running application extends these for use. Never build inside 
of an core 42viral abstract, always build in the inherited class. This will make upgrading far more feasible.

##  Configuration  

Any file containing configuration variables should be added to the .gitignore file. The current "Configuration" files 
are as follows:

* app/Config/core.php
* app/Config/database.php
* app/Config/email.php

Once ignored we need to put a ".default" in place:

* app/Config/core.php.default
* app/Config/database.php.default
* app/Config/email.php.default

## Installation

### Writable Paths

The following paths must be writable by the server.

* app/tmp
* app/webroot/cache
* app/webroot/img/people
* app/webroot/files/people

Lets say your application belongs to the user jasonsnider, you can use the following method to change owner ship to 
the web server and jasonsnider's user group, 775 are the desired permissions here. If you have a root shell you'll
want to remove the sudo command.

    sudo chown www-data:jasonsnider -fR app/tmp && chmod 775 -fR app/tmp 
    sudo chown www-data:jasonsnider -fR app/webroot/cache && chmod 775 -fR app/webroot/cache
    sudo chown www-data:jasonsnider -fR app/webroot/img/people && chmod 775 -fR app/webroot/img/people
    sudo chown www-data:jasonsnider -fR app/webroot/files/people && chmod 775 -fR app/webroot/files/people 

You can also use the following commands to make these writable. Personally, I'm not a fan of this approach as I feel it
is less secure. If you have a root shell you'll want to remove the sudo command.

    sudo chmod 777 -fR app/tmp 
    sudo chmod 777 -fR app/webroot/cache
    sudo chown 777 -fR app/webroot/img/people
    sudo chown 777 -fR app/webroot/files/people 

### Installing PHPUnit

#### Ubuntu Linux

    sudo apt-get install php-pear
    sudo pear channel-discover pear.phpunit.de
    sudo pear channel-discover components.ez.no
    sudo pear channel-discover pear.symfony-project.com
    sudo pear install phpunit/PHPUnit
    sudo apt-get install phpunit

#### Ubuntu 11-4

There seems to bea version bugin in Ubuntu 11.04, running this will force a new
version pear and fix the issue.

    sudo pear upgrade pear
    sudo pear install -a phpunit/PHPUnit

#### Debian/GNU Linux

    su root
    apt-get install php-pear
    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit
    apt-get install phpunit

#### REDHAT/FEDORA Linux

    su root
    yum install php-pear
    pear channel-discover pear.phpunit.de
    pear channel-discover components.ez.no
    pear channel-discover pear.symfony-project.com
    pear install phpunit/PHPUnit
    yum install php-unit



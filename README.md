The 42Viral Project
===================

Libraries and Concepts
----------------------
* CakePHP
* HTMLPurifier
* jQuery
* jQuery UI
* HTMLBOILERPLATE
* Modernizr

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



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

Please note that the git repository for 42Viral consists of several git submodules which are mostly Plugins and are
separate projects hosted on GitHub. You need to make sure you obtain all the submodules:

    cd app
    git submodule update --recursive --init

From a command line, navigate to your app directory and gain root access. (Required for setup as the script needs to
access chown). You'll provide 2 arguments the user name that apache runs as (probably www-data) and the group that will
have write access to the app directory (this is probably your username).

    sudo ./Console/cake setup [www-data] [production]

The setup shell is an interactive tool which enables you to quickly setup your application's essential configuration.

You can use the option "0" when you are setting your application for the first time. This will automatically run all
the setup steps in sequence.
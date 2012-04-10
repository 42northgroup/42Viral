# Plugin Configuration Plugin for CakePHP #

The PluginConfiguration Plugin works by returning a list of all the plugins installed in your application. If any of 
those plugins have a compatible configuration manager a link to that plugins' manager will be provided. A plugins'
management panel should include UI for saving configuration variables along with any diagnostic tools.

Configuration variables are stored and managed via the configurations table. The plugin provides a shell for saving the 
current state of the table as a configuration file.

## Installation ##


* As an archieve drop the PluginConfiguration into the Plugin directory.
* As a submodule 

    git submodule add git@github.com:jasonsnider/CakePHP-PluginConfiguration-Plugin.git

* in Config/bootstrap.php tell your application about the plugins' bootstrap file.

    CakePlugin::loadAll(array(
            'PluginConfiguration'=>array('bootstrap' => true)
        ));

* Run the schema file

    sudo Console/cake schema create --plugin PluginConfiguration --name PluginConfiguration

* Be sure to clean your model cache after the install. 
* Navigate to [your-site.com]/admin/plugin_configuration/configurations

## Requirements ##

* PHP version: PHP 5.3+
* CakePHP version: CakePHP 2.0+

## Support ##

Feel free to report issues via GitHub.

## License ##

Copyright 2012, [Jason D Snider](https://jasonsnider.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.


## Copyright ###

Copyright 2012<br/>
[Jason D Snider](https://root@jasonsnider.com)<br/>
https://jasonsnider.com<br/>

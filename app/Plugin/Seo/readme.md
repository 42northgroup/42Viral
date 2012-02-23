# SEO Plugin for CakePHP #

The SEO plugin adds SEO best practices to your cake application. It creates disambiguated slugs and canonical links

## Installation ## 

#Drop the Seo plugin into the Plugin directory
#Add CakePlugin::load('Seo'); to your bootstrap.php file
#Make sure the tables on which your adding this behavior have the following columns
*slug
*base_slug
*canonical

    public $contents = array(
    'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'key' => 'unique', 'collate' => 'latin1_swedish_ci', 'comment' => 'This is your disambiguated slug', 'charset' => 'latin1'),
    'base_slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 500, 'collate' => 'latin1_swedish_ci', 'comment' => 'This is your slug before being disambiguated', 'charset' => 'latin1'),
    'canonical' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'Your preferred version of a URL for the disambiguation of like content ', 'charset' => 'latin1'),
    );

*set your $Model->find* to search on slug

## Usage ##
SeoBehavior expects a title column, if your table has one, you may simply add the following to your model
    public $actsAs = array(
    'Seo.Seo'
    );

Otherwise you may use the convert setting against a given column, for example if name is the equivalent of title
    public $actsAs = array(
        'Seo.Seo'=>array(
            'convert'=>'name'
        )
    );

## Requirements ##

* PHP version: PHP 5.3+
* CakePHP version: CakePHP 2.0+

## Support ##


## License ##

Copyright 2012, [Jason D Snider](https://jasonsnider.com)

Licensed under [The MIT License](http://www.opensource.org/licenses/mit-license.php)<br/>
Redistributions of files must retain the above copyright notice.

## Copyright ###

Copyright 2012<br/>
[Jason D Snider](https://root@jasonsnider.com)<br/>
https://jasonsnider.com<br/>

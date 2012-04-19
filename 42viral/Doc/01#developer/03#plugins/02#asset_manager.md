## AssetManager

### Defining asset collections

The __Asset Manager__ is a plug-in which streamlines the task of combining and compressing JS and CSS resources. Using
the asset manager API you would define asset collections as such:

    $this->Asset->addAssets(array(
        'jquery.js',
        'common.js',
        'my_app.js',

        'reset.css',
        'base.css',
        'main.css',
        'page.css'
    ), 'my_app_resources');

### Using defined asset collections

After defining an asset collection such as the example above at the point in your view files (layout, template, element)
where you'd like to include the assets you would use:

    echo $this->Asset->buildAssets('js', 'my_app_resources');
    echo $this->Asset->buildAssets('css', 'my_app_resources');

The asset helper will concatenate all JS and CSS files and minify them. It will also generate a unique hash which is
calculated from a combination of the file names and their last modification time which would prevent any browser caching
issues. That means if you edit a file from the asset collection you'd essentially have a new hash for the final asset
file.

Also the minification can be turned off by setting the __MINIFY_ASSETS__ constant to false for debugging purposes. You
can set this in the [Your Application Path]/Plugin/AssetManager/Config/bootstrap.php file.

### Asset Packages

There's an even easier way to define and re-use asset collection we call __Asset Packages__.

    $assetPackages = array(
        'jquery' => array(
            'js/jquery/jquery-1.7.2.js'
        ),

        'fancybox' => array(
            '/css/ronco/jquery.fancybox-1.3.1/jquery.fancybox-1.3.1.css',
            '/js/ronco/jquery.fancybox-1.3.1/jquery.fancybox-1.3.1.pack.js'
        )
    );

This allows you to prepare pre-defined collection of assets which can be referenced using a single string. The advantage
here is say for example you upgrade your jQuery library, it would reflect anywhere you are referencing the jQuery
asset package. This makes site wide library upgrades a breeze.

    echo $this->Asset->buildAssetPackage('jquery');
    echo $this->Asset->buildAssetPackage('fancybox');

If you'd like to extend the list of preset asset packages you can do so in the AssetManager/Config/AssetPackage.php
file by adding your own collections to the $presets class static variable.
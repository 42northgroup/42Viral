#!/usr/bin/php -q
<?php
$ds = DIRECTORY_SEPARATOR;
$paths = explode(PATH_SEPARATOR, ini_get('include_path'));
$dispatcher = 'Cake' . $ds . 'Console' . $ds . 'ShellDispatcher.php';

foreach ($paths as $path) {
    if(stripos($path, 'cake')) {
        if (file_exists($path . $ds . $dispatcher)) {
            echo $path . ' ';
        }
	}
}

unset($paths, $path, $found, $dispatcher, $ds);

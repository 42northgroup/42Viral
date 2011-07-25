#!/bin/bash

path=/var/www/vhosts/42viral.build/httpdocs
user=www-data
group=jasonsnider

paths="
    $path/app/Config
    $path/app/tmp
    $path/app/webroot/cache
    $path/app/webroot/img/people
    $path/app/webroot/files/people
    $path/app/vendors/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer.php
    $path/app/vendors/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer
"

for $path in $paths
do
    chown 775 chmod 775 -fR $user:$group $path -fR  && chmod 775 $path -fR
done

cp $path/app/Config/core.php.default $path/app/Config/core.php
cp $path/app/Config/database.php.default $path/app/Config/database.php

echo "After setup is complete you should probably take access to '$path'/app/Config away from '$user'"
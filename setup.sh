#!/bin/bash
# Sets write paths and default config files

# git submodule init && git submodule update

# cd Plugin/ContentFilters && git submodule init && git submodule update && cd ../../

# cd Plugin/Imagine && git submodule init && git submodule update && cd ../../

# Absolute path to this script, e.g. /var/www/htdocs/app/setup.sh
SCRIPT=`readlink -f $0`

# Absolute path this script is in, thus /var/www/htdocs/app
SCRIPT_PATH=`dirname $SCRIPT`

# We'll start off with 0 errors
ERROR=0

# APACHE_PROCESS="www-data"
# USER="jasonsnider"

APACHE_PROCESS="$1"
USER="$2"

if [ $# -ne 2 ]
then
echo "Usage: $0 {USER} {APACHE_PROCESS}"
        echo "Enter the name your web server runs under - probably www-data"
        echo "Enter the group that will have write acces to the server - probably your user name"
        exit 1
fi


echo 'Setting permissions'

touch $SCRIPT_PATH/tmp/logs/error.log
touch $SCRIPT_PATH/tmp/logs/debug.log

# Set proper permissions to the newly created files

# DO NOT allow the Apache process to write to the config files!
for CONFIG_PATH in $CONFIG_PATHS
do
    chown "$USER":"$USER" -fR "$SCRIPT_PATH$CONFIG_PATH" && chmod 775 -fR "$SCRIPT_PATH$CONFIG_PATH"
    echo "+++$SCRIPT_PATH$CONFIG_PATH"
done

# Allow the Apache Process and at least 1 system user to write to the following directories
chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Plugin/ContentFilters/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
chmod 777 -fR "$SCRIPT_PATH/Plugin/ContentFilters/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
echo ">>>$SCRIPT_PATH/Plugin/ContentFilters/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Plugin/HtmlFromDoc/Vendor/PostOffice"
chmod 777 -fR "$SCRIPT_PATH/Plugin/HtmlFromDoc/Vendor/PostOffice"
echo ">>>$SCRIPT_PATH/Plugin/HtmlFromDoc/Vendor/PostOffice"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/tmp"
chmod 775 -fR "$SCRIPT_PATH/tmp"
echo ">>>$SCRIPT_PATH/tmp"

chown "$APACHE_PROCESS":"$USER" -fR webroot/cache
chmod 775 -fR "$SCRIPT_PATH/webroot/cache"
echo ">>>$SCRIPT_PATH/webroot/cache"

chown "$APACHE_PROCESS":"$USER" -fR webroot/img/people
chmod 775 -fR "$SCRIPT_PATH/webroot/img/people"
echo ">>>$SCRIPT_PATH/img/people"

chown "$APACHE_PROCESS":"$USER" -fR webroot/files/people
chmod 775 -fR "$SCRIPT_PATH/webroot/files/people"
echo ">>>$SCRIPT_PATH/webroot/files/people"

chown "$APACHE_PROCESS":"$USER" -fR webroot/files/temp
chmod 775 -fR "$SCRIPT_PATH/webroot/files/temp"
echo ">>>$SCRIPT_PATH/webroot/files/temp"

chown "$APACHE_PROCESS":"$USER" -fR webroot/files/doc_images
chmod 775 -fR "$SCRIPT_PATH/webroot/files/doc_images"
echo ">>>$SCRIPT_PATH/webroot/files/doc_images"

cp -r $SCRIPT_PATH/Config/Defaults/Xml/* $SCRIPT_PATH/Config/Xml/
echo ">>>Copying default xml configurations to their target $SCRIPT_PATH/Config/Xml/"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Config/Xml"
chmod 775 -fR "$SCRIPT_PATH/Config/Xml"
echo ">>>$SCRIPT_PATH/Config/Xml"

cp -r $SCRIPT_PATH/Config/Defaults/Includes/* $SCRIPT_PATH/Config/Includes/
echo ">>>Copying default includes configurations to their target $SCRIPT_PATH/Config/Includes/"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Config/Includes"
chmod 775 -fR "$SCRIPT_PATH/Config/Includes"
echo ">>>$SCRIPT_PATH/Config/Includes"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Config/Backup"
chmod 775 -fR "$SCRIPT_PATH/Config/Backup"
echo ">>>$SCRIPT_PATH/Config/Backup"

chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/Config/Log"
chmod 775 -fR "$SCRIPT_PATH/Config/Log"
echo ">>>$SCRIPT_PATH/Config/Log"

chown "$USER":"$USER" -fR "$SCRIPT_PATH/Plugin/PluginConfiguration/Config/application.php"
chmod 775 -fR "$SCRIPT_PATH/Plugin/PluginConfiguration/Config/application.php"
echo ">>>$SCRIPT_PATH/Plugin/PluginConfiguration/Config/application.php"



#Determine CakePHP core library location from php.ini include paths and set proper cache folder permissions
LIB=$(cd -P -- "$(dirname -- "$0")" && pwd -P) && LIB=$LIB/$(basename -- "$0")
LIB=$(dirname -- "$LIB")/

PHP_INC_PATH=($(exec php -q "$LIB"Console/get_php_inc_path.php))

len=${#PHP_INC_PATH[*]}
i=0
while [ $i -lt $len ]; do
    chown "$APACHE_PROCESS":"$USER" -fR "${PHP_INC_PATH[$i]}/Cake/Cache"
    chmod 775 -fR "${PHP_INC_PATH[$i]}/Cake/Cache"
    echo ">>>${PHP_INC_PATH[$i]}/Cake/Cache"

	let i++
done



echo 'Permissions set'

touch "$SCRIPT_PATH/Config/Log/setup_shell.txt"
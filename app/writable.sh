#!/bin/bash

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

for CONFIG_PATH in $CONFIG_PATHS
do
    chown "$USER":"$USER" -fR "$SCRIPT_PATH$CONFIG_PATH" && chmod 775 -fR "$SCRIPT_PATH$CONFIG_PATH"
    echo "+++$SCRIPT_PATH$CONFIG_PATH"
done

# chown "$APACHE_PROCESS":"$USER" -fR "$SCRIPT_PATH/42viral/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializerendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
chmod 777 -fR "$SCRIPT_PATH/42viral/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"
echo ">>>$SCRIPT_PATH/42viral/Vendor/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer"

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

echo 'Permissions set'


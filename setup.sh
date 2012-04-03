#!/bin/bash

# We'll start off with 0 errors
ERROR=0

# Absolute path to this script, e.g. /var/www/htdocs/app/setup.sh
SCRIPT=`readlink -f $0`

# Absolute path this script is in, thus /var/www/htdocs/app
SCRIPT_PATH=`dirname $SCRIPT`

APACHE_PROCESS="$1"
USER_GROUP="$2"

if [ $# -ne 2 ]
then
    echo "Usage: $0 {APACHE_PROCESS} {USER_GROUP}"
    echo "Enter the name your web server runs under - probably www-data"
    echo "Enter the group that will have write acces to the server - probably your user name"
    exit 1
fi

# Cleans cache and resets file permissions
rm -f $SCRIPT_PATH/tmp/cache/models/cake_*
rm -f $SCRIPT_PATH/tmp/cache/persistent/cake_*
rm -f $SCRIPT_PATH/tmp/cache/views/cake_*

# Trigger the execution of the cake setup shell
sudo $SCRIPT_PATH/Console/cake setup main $APACHE_PROCESS $USER_GROUP

# Create log files
touch $SCRIPT_PATH/tmp/logs/error.log
touch $SCRIPT_PATH/tmp/logs/debug.log

chown "$APACHE_PROCESS":"$USER_GROUP" -fR "$SCRIPT_PATH/tmp"
chmod 775 -fR "$SCRIPT_PATH/tmp"

chown "$APACHE_PROCESS":"$USER_GROUP" -fR "$SCRIPT_PATH/tmp"
chmod 775 -fR "$SCRIPT_PATH/tmp"

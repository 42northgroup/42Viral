#!/bin/bash 

# Absolute path to this script, e.g. /var/www/htdocs/app/setup.sh
SCRIPT=`readlink -f $0`

# Absolute path this script is in, thus /var/www/htdocs/app
SCRIPT_PATH=`dirname $SCRIPT`

# An array of all of the config files we need to create
CONFIG_PATHS="
    /Config/acl.ini.php
    /Config/app.php
    /Config/bootstrap.php
    /Config/core.php
    /Config/database.php
    /Config/email.php
    /Config/routes.php
"

for CONFIG_PATH in $CONFIG_PATHS
do
    echo "Removing $SCRIPT_PATH$CONFIG_PATH"
    rm "$SCRIPT_PATH$CONFIG_PATH"
done






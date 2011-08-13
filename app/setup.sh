#!/bin/bash 

# Absolute path to this script, e.g. /var/www/htdocs/app/setup.sh
SCRIPT=`readlink -f $0`

# Absolute path this script is in, thus /var/www/htdocs/app
SCRIPT_PATH=`dirname $SCRIPT`

# We'll start off with 0 errors
ERROR=0

APACE_PROCESS="www-data"

USER="jasonsnider"

# WHY DOESN'T THIS WORK
# if [ "$APACHE_PROCESS" == "" ]
# then
#     echo "Please set the value for your APACHE_PROCESS, this is often www-data"
#     exit 0
# fi

# if [ "$USER" == "" ]; then
#     echo "Please set the value for USER, this should be the user that could log on and update files"
#     exit 0
# fi

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
# We will create the config files by make a copy of the defaults

# Are all of the config paths in place?
for CONFIG_PATH in $CONFIG_PATHS
do
    if [ ! -f "$SCRIPT_PATH$CONFIG_PATH.default" ] 
    then
        echo "*** Missing default config file $SCRIPT_PATH$CONFIG_PATH.default"
        ERROR=1
    fi
done

# If we are missing a config path, stop executing other wise, build them all
if [ $ERROR -eq 0 ]
then
    echo '+++ Success - All default config file are accounted for'

    echo 'Writing config files...'

    for CONFIG_PATH in $CONFIG_PATHS
    do
        echo "Writing $SCRIPT_PATH$CONFIG_PATH"
        cp "$SCRIPT_PATH$CONFIG_PATH.default" "$SCRIPT_PATH$CONFIG_PATH"
    done

else 
    echo '*** Error - The indicated default config files are missing, exiting setup'
    exit 0
fi

echo 'Setting permissions'

# Set proper permissions to the newly created files

# TODO - LOOP
# TODO - Request Feedback - apaches process user?
# TODO - Request Feedback - human user?

for CONFIG_PATH in $CONFIG_PATHS
do
    chown "$USER":"$USER" -fR "$SCRIPT_PATH$CONFIG_PATH" && chmod 775 -fR "$SCRIPT_PATH$CONFIG_PATH" 
done

chown "$APACHE_PROCESS":"$USER" -fR tmp  
chmod 775 -fR tmp 

chown "$APACHE_PROCESS":"$USER" -fR webroot/cache
chmod 775 -fR /webroot/cache

chown "$APACHE_PROCESS":"$USER" -fR webroot/img/people
chmod 775 -fR webroot/img/people

chown "$APACHE_PROCESS":"$USER" -fR webroot/files/people
chmod 775 -fR webroot/files/people 

echo 'Permissions set'





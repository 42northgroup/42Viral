#!/bin/bash 

SITE_NAME="$1"

if [ $ -ne 1 ]
then
    echo "Usage: $0 {SITE_NAME}"
    echo "Enter the name of the site you wish to restart (This is the name of the file that contains the vhost entry)."
    exit 1
fi

echo "Disabling $SITE_NAME..."
a2dissite SITE_NAME

echo "Restarting Apache..."
/etc/init.d/apache2 restart

echo "Enabling $SITE_NAME..."
a2densite SITE_NAME

echo "Restarting Apache..."
/etc/init.d/apache2 restart
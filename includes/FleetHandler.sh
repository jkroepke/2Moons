#!/bin/sh
FH_DIR=/var/www

if [ ! -d /usr/bin/php ]; then
  echo "Can't find php"
  exit 1 #exit shell script
fi
if [ ! -f ${FH_DIR}includes/FleetHandler.php ]; then
  echo "Can't find FleetHandler.php"
  exit 1 #exit shell script
fi

while [ 1 ]
  do php -f ${FH_DIR}includes/FleetHandler.php
  sleep 1
done
#!/bin/sh
FH_DIR=/var/www

if [ ! -d /etc/php5/cli ]; then
  echo "Can't find php"
  exit 1 #exit shell script
fi
if [ ! -f file ]; then
  echo "Can't find FleetHandler.php"
  exit 1 #exit shell script
fi

while [ bedingung ]
  do php -f ${FH_DIR}includes\FleetHandler.php
  sleep 1
done
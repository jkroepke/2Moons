@echo off
set PHP_DIR=C:\xampp\php\
set FH_DIR=C:\xampp\htdocs\2moons\includes\
if not exist %PHP_DIR%php.exe goto PHP
if not exist %FH_DIR%FleetHandler.php goto FH
:Start
%PHP_DIR%php.exe -f %FH_DIR%FleetHandler.php
Goto Start

:PHP
echo "php.exe wurde nicht gefunden! (Richtiger Pfad?)"
goto end
:FH
echo "FleetHandler.php wurde nicht gefunden! (Richtiger Pfad?)"
goto end
:End
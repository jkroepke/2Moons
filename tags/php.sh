#!/bin/sh
# If you get Errors: http://www.robo47.net/text/6-PHP-Configure-und-Compile-Fehler
if [ $1 ] 
	then
		VERSION=$1
	else
		VERSION="php-5.3.5"
fi
apt-get update
apt-get install libbz2-dev libjpeg62 libjpeg62-dev libpng12-0 libpng12-dev libmcrypt4 libmcrypt-dev libxml2 libxml2-dev libfreetype6 libfreetype6-dev libreadline5-dev libmm-dev libmm14
wget http://de3.php.net/distributions/${VERSION}.tar.gz
tar xfz ${VERSION}.tar.gz
cd ${VERSION}
./configure '--prefix=/usr/local/php' '--with-config-file-path=/usr/local/php/lib' '--with-libxml-dir=/usr/local' '--with-zlib=/usr/local' '--with-xpm-dir=/usr/local' '--with-mysql=/usr/local/mysql' '--with-mysqli=/usr/local/mysql/bin/mysql_config' '--with-apxs2=/usr/bin/apxs2' '--disable-debug' '--with-pic' '--disable-rpath' '--with-pear=shared,/usr' '--with-bz2' '--with-curl' '--with-exec-dir=/usr/bin' '--with-freetype-dir=/usr' '--with-png-dir=/usr' '--enable-gd-native-ttf' '--without-gdbm' '--with-gettext' '--with-iconv' '--with-jpeg-dir=/usr' '--with-openssl' '--with-pcre-regex=/usr' '--with-zlib' '--with-layout=GNU' '--enable-exif' '--enable-ftp'  '--enable-sockets' '--enable-sysvsem' '--enable-sysvshm' '--enable-sysvmsg' '--enable-wddx' '--with-kerberos' '--enable-ucd-snmp-hack' '--enable-shmop' '--enable-calendar' '--without-sqlite' '--with-libxml-dir=/usr' '--enable-xml' '--enable-pcntl' '--with-imap=shared' '--with-imap-ssl' '--enable-mbstring=shared' '--enable-mbregex' '--with-gd=shared' '--enable-bcmath=shared' '--enable-dba=shared' '--with-db4=/usr' '--with-xmlrpc=shared' '--with-ldap=shared' '--with-ldap-sasl' '--with-mysql=shared,/usr' '--with-mysqli=shared,/usr/bin/mysql_config' '--enable-dom=shared' '--with-pgsql=shared' '--with-snmp=shared,/usr' '--enable-soap=shared' '--with-xsl=shared,/usr' '--enable-xmlreader=shared' '--enable-xmlwriter=shared' '--enable-pdo=shared' '--with-pdo-odbc=shared,unixODBC,/usr' '--with-pdo-mysql=shared,/usr' '--with-pdo-pgsql=shared,/usr' '--with-pdo-sqlite=shared,/usr' '--with-pdo-dblib=shared,/usr' '--enable-json=shared' '--enable-zip=shared' '--with-readline' '--with-mcrypt=shared,/usr' '--with-mhash=shared,/usr' '--with-mssql=shared,/usr' '--with-unixODBC=shared,/usr' 
make all
make test
make install
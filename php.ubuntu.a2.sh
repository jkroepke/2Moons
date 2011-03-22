#!/bin/sh
# If you get Errors: http://www.robo47.net/text/6-PHP-Configure-und-Compile-Fehler

PREFIX=/usr;
php_sysconf=/etc/php5
sapi=apache2

if [ $1 ] 
	then
		VERSION=$1
	else
		VERSION="php-5.3.6"
fi

apt-get update
apt-get install libxpm-dev libbz2-dev libjpeg62 libjpeg62-dev libxslt1-dev libxslt1.1 libpng12-0 libsnmp-dev libpng12-dev libmcrypt4 libmcrypt-dev libxml2 libxml2-dev libfreetype6 libfreetype6-dev libreadline5-dev libmm-dev libmm14 libc-client2007e libc-client2007e-dev libsasl2-2 libsasl2-dev libsasl2-modules freetds-common freetds-dev -y
apt-get remove php5-common php5-dev libapache2-mod-php5 -y
wget http://de3.php.net/distributions/${VERSION}.tar.gz -nc
tar xfz ${VERSION}.tar.gz
cd ${VERSION}
#make clean;
#rm ./config.cache;
./configure \
	--prefix=$PREFIX \
	--sysconfdir=/etc/php5/$sapi \
	--with-config-file-path=/etc/php5/$sapi \
	--with-config-file-scan-dir=/etc/php5/$sapi/conf.d \
	--with-apxs2=$PREFIX/bin/apxs2 \
	--disable-debug \
	--disable-phar \
	--disable-rpath \
	--enable-bcmath \
	--enable-dba \
	--enable-dom \
	--enable-exif \
	--enable-ftp \
	--enable-gd-native-ttf \
	--enable-intl \
	--enable-json \
	--enable-mbstring \
	--enable-mbregex \
	--enable-pcntl \
	--enable-pdo \
	--enable-soap \
	--enable-sockets \
	--enable-sqlite-utf8 \
	--enable-sysvsem \
	--enable-sysvshm \
	--enable-sysvmsg \
	--enable-xml \
	--enable-xmlreader \
	--enable-xmlwriter \
	--enable-zend-multibyte \
	--enable-zip \
	--with-bz2 \
	--with-curl \
	--with-curlwrappers \
	--with-db4=$PREFIX \
	--with-exec-dir=$PREFIX/bin \
	--with-freetype-dir=$PREFIX \
	--with-gd \
	--with-gettext \
	--with-iconv \
	--with-jpeg-dir=$PREFIX \
	--with-layout=GNU \
	--with-ldap \
	--with-ldap-sasl \
	--with-libxml-dir=$PREFIX \
	--with-mcrypt=$PREFIX \
	--with-mhash=$PREFIX \
	--with-mysql=$PREFIX/local/mysql \
	--with-mysqli=$PREFIX/bin/mysql_config \
	--with-openssl \
	--with-pcre-regex=$PREFIX \
	--with-pear=$PREFIX \
	--with-pdo-mysql=$PREFIX \
	--with-pdo-sqlite=$PREFIX \
	--with-pdo-dblib=$PREFIX \
	--with-pic \
	--with-png-dir=$PREFIX \
	--with-readline \
	--with-pgsql \
	--with-xmlrpc \
	--with-xpm-dir=$PREFIX/local \
	--with-xsl=$PREFIX \
	--with-zlib=$PREFIX/local \
	--without-gdbm;
make all
#make test
make install
/etc/init.d/apache2 restart
php -v
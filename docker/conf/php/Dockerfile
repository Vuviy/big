FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
	curl \
	wget \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	libxslt-dev \
	libicu-dev \
	libmcrypt-dev \
	libxml2-dev \
	libzip-dev \
	libonig-dev \
	libpq-dev \
	poppler-utils

RUN docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip calendar
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl xsl soap exif

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./docker/conf/php/php.ini /usr/local/etc/php/php.ini

RUN pecl install xdebug redis
RUN docker-php-ext-enable redis

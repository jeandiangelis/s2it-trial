FROM php:7.0-apache

WORKDIR /var/www/s2it-trial

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    git \
    libjpeg-dev \
    unzip \
    libpng-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql bcmath \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd \
    && a2enmod rewrite \
    && pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY dev.s2it-trial.com.conf /etc/apache2/sites-enabled/000-default.conf
FROM php:8.0.6-fpm-buster
COPY php.ini /usr/local/etc/php/
RUN apt-get update \
        && apt-get install -y \
        git \
        zip \
        unzip \
        vim \
        libzip-dev
RUN docker-php-ext-install pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/app
RUN composer global require "laravel/installer"
FROM php:8-fpm

WORKDIR /var/www/html/

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
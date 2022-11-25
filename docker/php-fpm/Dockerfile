FROM php:8-fpm

WORKDIR /var/www/html/

RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y apt-transport-https libzip-dev
RUN pecl install zip
RUN apt-get install zip unzip

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD bash -c "composer install && ./vendor/bin/doctrine-migrations migrate"

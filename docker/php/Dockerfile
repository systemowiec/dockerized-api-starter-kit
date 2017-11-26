FROM php:7.0-fpm

RUN docker-php-ext-install pdo_mysql

# fix permissions
RUN usermod -u 1000 www-data

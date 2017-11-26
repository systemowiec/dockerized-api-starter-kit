FROM php:7.0-fpm

RUN docker-php-ext-install pdo_mysql

RUN apt-get update
RUN apt-get install -y git unzip

# install composer
RUN curl https://getcomposer.org/installer > /tmp/composer-installer.php
RUN /usr/local/bin/php /tmp/composer-installer.php
RUN mv /var/www/html/composer.phar /usr/local/bin/composer

# fix permissions
RUN usermod -u 1000 www-data

FROM php:8.3-apache-bookworm

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80

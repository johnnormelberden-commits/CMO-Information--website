FROM php:8.3-apache-bookworm

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

RUN apache2ctl -M 2>&1 | grep -E "mpm_|AH00534" || true

EXPOSE 80

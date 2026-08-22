FROM php:8.3-apache

RUN a2dismod mpm_event mpm_worker mpm_prefork || true \
    && a2enmod mpm_prefork \
    && docker-php-ext-install mysqli

WORKDIR /var/www/html

COPY . /var/www/html

RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]

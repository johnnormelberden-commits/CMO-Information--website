#!/bin/bash

set -e

a2dismod mpm_event mpm_worker mpm_prefork || true
a2enmod mpm_prefork

sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/" /etc/apache2/sites-available/000-default.conf

exec apache2-foreground

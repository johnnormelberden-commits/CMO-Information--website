#!/bin/bash

set -e

# ============================================================
# RAILWAY PORT
# ============================================================

PORT="${PORT:-8080}"

echo "========================================"
echo "Starting Apache"
echo "Railway PORT: ${PORT}"
echo "========================================"


# ============================================================
# FIX APACHE MPM
# ============================================================
#
# Apache can only have ONE MPM enabled.
# Disable all MPM modules first, then enable prefork.
#

a2dismod mpm_event || true
a2dismod mpm_worker || true
a2dismod mpm_prefork || true

a2enmod mpm_prefork


# ============================================================
# CONFIGURE APACHE PORT
# ============================================================

cat > /etc/apache2/ports.conf <<EOF
Listen ${PORT}
EOF


# ============================================================
# CONFIGURE DEFAULT APACHE SITE
# ============================================================

cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:${PORT}>

    ServerAdmin webmaster@localhost

    DocumentRoot /var/www/html

    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/error.log
    CustomLog \${APACHE_LOG_DIR}/access.log combined

</VirtualHost>
EOF


# ============================================================
# START APACHE
# ============================================================

echo "Apache configured to listen on port ${PORT}"

echo "Starting Apache on port ${PORT}"

exec apache2-foreground

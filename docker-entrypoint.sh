#!/bin/bash

set -e

# ============================================================
# APACHE MODULES
# ============================================================

a2dismod mpm_event mpm_worker mpm_prefork || true
a2enmod mpm_prefork

# ============================================================
# RAILWAY PORT
# ============================================================
# Railway provides PORT for the web application.
# If PORT is not available, use 8080.
# ============================================================

APP_PORT="${PORT:-8080}"

echo "Starting Apache on port ${APP_PORT}"

# ============================================================
# CONFIGURE APACHE PORT
# ============================================================

sed -i "s/^Listen .*/Listen ${APP_PORT}/" /etc/apache2/ports.conf

sed -i \
  "s/<VirtualHost \*:[0-9]*>/<VirtualHost *:${APP_PORT}>/" \
  /etc/apache2/sites-available/000-default.conf

# ============================================================
# START APACHE
# ============================================================

exec apache2-foreground

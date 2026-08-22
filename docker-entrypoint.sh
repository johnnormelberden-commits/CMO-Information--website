#!/bin/bash

set -e

# Railway provides the web PORT automatically.
# If PORT is not available, use 80.
PORT="${PORT:-80}"

echo "Starting Apache on port ${PORT}"

# Make sure Apache uses the Railway PORT
sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf

sed -i "s/<VirtualHost \*:[0-9]\+>/<VirtualHost *:${PORT}>/" \
    /etc/apache2/sites-available/000-default.conf

# Start Apache
exec apache2-foreground

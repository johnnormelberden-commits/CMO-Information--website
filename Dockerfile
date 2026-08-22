FROM php:8.3-apache-bookworm

# Install MySQL/Mysqli extension
RUN docker-php-ext-install mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy website files
COPY . /var/www/html/

# Copy Railway Apache startup script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

# Make startup script executable
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Railway will provide PORT at runtime
EXPOSE 80

# Start Apache using our script
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

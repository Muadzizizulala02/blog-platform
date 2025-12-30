# Use the modern ServerSideUp image with PHP 8.4
FROM serversideup/php:8.4-fpm-nginx

# Set the working directory
WORKDIR /var/www/html

# Copy all files AND set permissions to the web user (www-data)
COPY --chown=www-data:www-data . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup the migration script (Run as root so it can execute system tasks if needed)
COPY scripts/00-laravel-deploy.sh /etc/entrypoint.d/99-laravel-deploy.sh
RUN chmod +x /etc/entrypoint.d/99-laravel-deploy.sh
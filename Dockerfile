# Use the modern ServerSideUp image with PHP 8.4
FROM serversideup/php:8.4-fpm-nginx

# Set the working directory
WORKDIR /var/www/html

# Copy all your files to the container
COPY . .

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Setup the migration script to run automatically
# ServerSideUp runs any script in /etc/entrypoint.d/ on startup
COPY scripts/00-laravel-deploy.sh /etc/entrypoint.d/99-laravel-deploy.sh
RUN chmod +x /etc/entrypoint.d/99-laravel-deploy.sh
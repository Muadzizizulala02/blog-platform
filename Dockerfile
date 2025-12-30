FROM serversideup/php:8.4-fpm-nginx

# 1. Switch to root to install the system deployment script
USER root
COPY scripts/00-laravel-deploy.sh /etc/entrypoint.d/99-laravel-deploy.sh
RUN chmod +x /etc/entrypoint.d/99-laravel-deploy.sh

# 2. Switch back to the web user for application installation
USER www-data
WORKDIR /var/www/html

# 3. Copy app files with correct ownership
COPY --chown=www-data:www-data . .

# 4. Install dependencies
RUN composer install --no-dev --optimize-autoloader
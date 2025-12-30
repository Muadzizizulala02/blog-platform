FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Image config
ENV SKIP_COMPOSER 0
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the deploy script and make it executable
COPY scripts/00-laravel-deploy.sh /conf/scripts/00-laravel-deploy.sh
RUN chmod +x /conf/scripts/00-laravel-deploy.sh

CMD ["/start.sh"]
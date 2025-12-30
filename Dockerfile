# --- Stage 1: Build Frontend Assets (Node.js) ---
FROM node:20 AS frontend
WORKDIR /app
COPY . .
RUN npm install
RUN npm run build

# --- Stage 2: Production Server (PHP) ---
FROM serversideup/php:8.4-fpm-nginx

# Switch to root to install the deployment script
USER root
COPY scripts/00-laravel-deploy.sh /etc/entrypoint.d/99-laravel-deploy.sh
RUN chmod +x /etc/entrypoint.d/99-laravel-deploy.sh

# Switch back to web user
USER www-data
WORKDIR /var/www/html

# Copy the app code
COPY --chown=www-data:www-data . .

# Copy the compiled assets from Stage 1 (The Magic Fix)
COPY --from=frontend --chown=www-data:www-data /app/public/build ./public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader
#!/usr/bin/env bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "📂 Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🚀 Running migrations..."
php artisan migrate --force

echo "✅ Deployment ready!"
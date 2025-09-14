#!/bin/bash
echo "🚀 Deploying Laravel Blog Application..."

# Maintenance mode
php artisan down

# Get latest changes
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Run migrations
php artisan migrate --force

# Clear caches
php artisan optimize:clear
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 755 storage bootstrap/cache

# Restart services (if needed)
# sudo systemctl restart apache2
# sudo systemctl restart php8.2-fpm

# Exit maintenance mode
php artisan up

echo "✅ Deployment completed!"

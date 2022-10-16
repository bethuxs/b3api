#!/usr/bin/env bash
echo "Running composer"
composer install

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache
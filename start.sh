#!/bin/bash

set -e

if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

if [ ! -f ".env" ]; then
    echo "Creating .env from .env.example..."
    cp .env.example .env
fi

echo "Generating application key..."
php artisan key:generate

echo "Running migrations..."
php artisan migrate --force

exec "$@"

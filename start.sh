#!/usr/bin/env bash

# Instala dependencias de Composer
composer install --no-dev --optimize-autoloader

# Ejecuta migraciones si quieres
php artisan migrate --force

# Inicia servidor (Render usa Apache o Nginx, no artisan serve)

#!/bin/bash

# Generar key si no existe
php artisan key:generate --force

# Ejecutar migraciones
php artisan migrate --force

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar PHP-FPM en background
php-fpm -D

# Iniciar Nginx en foreground
nginx -g 'daemon off;'

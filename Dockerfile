FROM php:8.2-fpm

# Build timestamp: 2025-11-29T17:00:00Z
# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www/html

# Copiar el resto de la aplicación
COPY . .

# Instalar dependencias de PHP (ignorando requisitos de plataforma)
RUN composer install --ignore-platform-reqs --optimize-autoloader --no-dev

# Generar autoload optimizado
RUN composer dump-autoload --optimize --ignore-platform-reqs

# Crear directorios necesarios y configurar permisos
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && chmod 664 database/database.sqlite

# Configurar Nginx
RUN echo 'server {\n\
    listen 8080;\n\
    root /var/www/html/public;\n\
    index index.php;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/sites-available/default

# Crear archivo .env con valores por defecto
RUN echo "APP_NAME=Laravel\n\
APP_ENV=production\n\
APP_KEY=base64:oSh+YTk/oBPTUHDtLXfCYoq1xJlLTfy6wqF06+imV0k=\n\
APP_DEBUG=false\n\
APP_URL=https://proyecto-1-wobq.onrender.com\n\
LOG_CHANNEL=stderr\n\
DB_CONNECTION=sqlite\n\
DB_DATABASE=/var/www/html/database/database.sqlite" > .env

# Script de inicio
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Limpiando cache..."\n\
php artisan cache:clear\n\
php artisan config:clear\n\
php artisan route:clear\n\
php artisan view:clear\n\
echo "Regenerando autoloader..."\n\
composer dump-autoload --optimize --ignore-platform-reqs\n\
echo "Ejecutando migraciones..."\n\
php artisan migrate:fresh --force\n\
echo "Ejecutando seeders..."\n\
php artisan db:seed --force\n\
echo "Optimizando aplicación..."\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
echo "Iniciando servicios..."\n\
php-fpm -D\n\
nginx -g "daemon off;"' > /start.sh && chmod +x /start.sh

EXPOSE 8080

CMD ["/start.sh"]

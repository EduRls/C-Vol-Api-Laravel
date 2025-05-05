FROM php:8.2-fpm

# Instala dependencias necesarias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    unzip curl git libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todo el proyecto
COPY . .

# Otorga permisos necesarios a storage y cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala dependencias del proyecto (sin dev)
RUN composer install --no-dev --optimize-autoloader

# Limpia y genera la caché de configuración
RUN php artisan config:clear && php artisan config:cache

# Expone el puerto usado por el servidor artisan
EXPOSE 8000

# Comando de inicio con corrección de permisos en tiempo de ejecución
CMD chmod -R 775 storage bootstrap/cache && php artisan serve --host=0.0.0.0 --port=8000

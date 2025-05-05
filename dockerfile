FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer desde imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece directorio de trabajo
WORKDIR /var/www

# Copia archivos del proyecto
COPY . .

# Da permisos a storage y bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache

# Expone puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan --version && php artisan serve --host=0.0.0.0 --port=8000
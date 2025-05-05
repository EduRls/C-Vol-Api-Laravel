FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git libpq-dev nginx \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
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

# Copia configuración de Nginx
COPY nginx.conf /etc/nginx/nginx.conf

# Expone puerto
EXPOSE 80

# Comando de inicio
CMD service nginx start && php-fpm

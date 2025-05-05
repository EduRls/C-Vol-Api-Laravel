FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crea directorio del proyecto
WORKDIR /var/www

# Copia archivos al contenedor
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache

# Puerto expuesto
EXPOSE 8000

# Comando de inicio
CMD php artisan serve --host=0.0.0.0 --port=8000
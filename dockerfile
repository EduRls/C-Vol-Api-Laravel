FROM php:8.2-fpm

# Instala dependencias del sistema necesarias
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia los archivos del proyecto
COPY . .

# Otorga permisos adecuados
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Genera la caché de configuración
RUN php artisan config:clear && php artisan config:cache

# Expone el puerto 8000
EXPOSE 8000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

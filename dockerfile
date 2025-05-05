FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev unzip curl git libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache

EXPOSE 8000

CMD php artisan key:generate --force && php artisan serve --host=0.0.0.0 --port=8000

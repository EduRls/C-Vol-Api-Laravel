# Usa la imagen oficial de PHP con Apache como servidor web
FROM php:8.2-apache

# Instala las dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Crea un usuario no privilegiado para ejecutar Composer
RUN useradd -ms /bin/bash laravel

# Cambia al usuario no privilegiado
USER laravel

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/home/laravel --filename=composer

# Copia el código de tu proyecto Laravel al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Instala las dependencias de Composer (incluyendo los de desarrollo)
#RUN composer install

# Establece los permisos adecuados en los directorios de almacenamiento
USER root
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Cambia nuevamente al usuario no privilegiado
USER laravel

# Expone el puerto 80 para que se pueda acceder a la aplicación a través del navegador
EXPOSE 8000

# Comando por defecto para iniciar Apache cuando se inicie el contenedor
CMD ["apache2-foreground"]

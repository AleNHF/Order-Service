# Usa una imagen de PHP como base
FROM php:8.1-fpm

# Configura el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Instala las dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
&& docker-php-ext-install zip pdo_mysql

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos de la aplicación al contenedor
COPY . /var/www/html

# Instala las dependencias de Composer
RUN composer install --no-interaction

# Expone el puerto en el que se ejecutará la aplicación
EXPOSE 8000

# Ejecuta el servidor de desarrollo de PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]

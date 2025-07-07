FROM php:8.2-apache

# Copia todo el proyecto al servidor Apache
COPY . /var/www/html/

# Habilita extensiones para PHP y MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

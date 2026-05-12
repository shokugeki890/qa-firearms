# PHP-FPM untuk Nginx
FROM php:8.2-fpm

# Git/zip for install library
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip

# Install MySQL extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Binary composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/myphpapp

# Set proper permissions
RUN chown -R www-data:www-data /var/www/myphpapp

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000
# Use the official PHP image as a base image
FROM php:8.3-fpm

LABEL authors="Tufan GOKMENLER"

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor \
    libonig-dev \
    libxml2-dev \
    libssl-dev \
    cron

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pcntl

# Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install

# Set permissions for the application directory
RUN chown -R www-data:www-data /var/www/html

RUN touch /var/log/finetunes.log
# Expose port 9000 (default for PHP-FPM) and start php-fpm server
EXPOSE 9000

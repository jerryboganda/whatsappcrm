FROM php:8.3-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    libzip-dev \
    unzip \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    gmp-dev \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl xml gmp

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000
CMD php-fpm

# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    curl \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip bcmath sockets \
    && pecl install redis \
    && docker-php-ext-enable redis

# Install Composer (Versi terbaru)
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Install Node.js dan npm untuk TailwindCSS & assets compilation
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Copy custom PHP configuration (Jika ada)
# COPY ./docker/php.ini /usr/local/etc/php/php.ini

# Copy application code
COPY ./ /var/www/html

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]

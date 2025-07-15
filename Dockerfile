# Gunakan base image PHP 8.2 (atau versi sesuai kebutuhan)
FROM php:8.2-fpm

# Install dependencies sistem
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libzip-dev \
    libpq-dev \
    libmcrypt-dev \
    libcurl4-openssl-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy semua file project ke dalam container
COPY . .

# Install dependency Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Copy file .env contoh (jika belum ada)
# RUN cp .env.example .env

# Generate key (kalau ingin langsung otomatis)
# RUN php artisan key:generate

# Beri permission storage & bootstrap
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Expose port untuk FPM
EXPOSE 9000

CMD ["php-fpm"]

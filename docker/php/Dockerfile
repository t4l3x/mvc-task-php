FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer.json and composer.lock
COPY /composer.* /var/www/

# Install dependencies
RUN composer install --no-scripts --no-autoloader --no-interaction --prefer-dist

# Copy the rest of the application
COPY . /var/www

# Generate the autoloader
RUN composer dump-autoload --optimize

CMD ["php-fpm"]

EXPOSE 9000
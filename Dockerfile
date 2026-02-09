# Stage 1: Install Composer Dependencies
FROM php:8.2-fpm-alpine as composer-builder
RUN apk add --no-cache curl zip unzip
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --no-dev --optimize

# Stage 2: Build assets with Node
FROM node:20-alpine as asset-builder
WORKDIR /app
COPY . .
# Copy vendor from composer-builder so Vite can find Ziggy
COPY --from=composer-builder /app/vendor ./vendor
RUN npm install --legacy-peer-deps
RUN npm run build

# Stage 3: Final PHP Image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    curl \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application source
COPY . .

# Copy vendor from composer-builder
COPY --from=composer-builder /app/vendor ./vendor

# Copy built assets from Stage 2
COPY --from=asset-builder /app/public/build ./public/build

# Setup Nginx config
COPY deploy/nginx.conf /etc/nginx/http.d/default.conf

# Directory permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

# Start script
COPY deploy/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["/usr/local/bin/start.sh"]

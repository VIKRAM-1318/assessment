FROM php:8.3-cli-alpine

# Install system packages & PHP extensions required for Laravel
RUN apk add --no-cache \
    sqlite-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    curl-dev \
    git \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_sqlite \
    mbstring \
    zip \
    gd \
    intl \
    opcache \
    bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy Laravel application files
COPY Application/ ./

# Set storage and bootstrap cache permissions
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Production environment variables
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV DB_CONNECTION=sqlite
ENV PORT=8000

# Expose server port
EXPOSE 8000

# Container startup: copy env, generate key, migrate, seed, and launch server
CMD php -r "file_exists('.env') || copy('.env.example', '.env');" \
    && php artisan key:generate --force \
    && touch database/database.sqlite \
    && php artisan migrate --force --seed \
    && php artisan storage:link \
    && php artisan serve --host=0.0.0.0 --port=${PORT}

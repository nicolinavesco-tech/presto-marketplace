FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif

# Abilita mod_rewrite
RUN a2enmod rewrite

# Imposta DocumentRoot su public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

COPY . .

RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Build frontend
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm ci \
    && npm run build

# Migrations al boot (puoi anche toglierle dopo)
CMD php artisan migrate --force && apache2-foreground
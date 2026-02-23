FROM php:8.4-apache

# 1) System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache config: rewrite + DocumentRoot = /public
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3) Install Node.js (così npm esiste)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && node -v && npm -v \
    && rm -rf /var/lib/apt/lists/*

# 4) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5) Copia tutto il progetto (così artisan esiste)
COPY . .

# 6) Dipendenze PHP (no-scripts per evitare sqlite/package:discover in build)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# 7) Build frontend (Vite) + check manifest
# Se hai package-lock.json => usa npm ci (consigliato)
RUN npm ci \
    && npm run build \
    && ls -la public || true \
    && ls -la public/build || true \
    && test -f public/build/manifest.json

# 8) Permessi Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# 9) Runtime: migrate (per Render free) + package discover + Apache
CMD sh -c "php artisan migrate --force || true; php artisan package:discover --ansi || true; apache2-foreground"
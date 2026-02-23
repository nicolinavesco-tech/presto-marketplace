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

# 3) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 4) Copia tutto il progetto (così artisan esiste quando composer esegue gli script)
COPY . .

# 5) Dipendenze PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# 6) Node + build Vite (public/build/manifest.json)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm ci \
    && npm run build \
    && test -f public/build/manifest.json

# 7) Permessi Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 8) Porta: Apache ascolta su 80, Render proxy fa il mapping
EXPOSE 80

# 9) (OPZIONALE ma utile su Render free) migrations all'avvio
# Se non vuoi farle ad ogni boot, puoi togliere migrate e farlo una volta sola.
CMD sh -c "php artisan migrate --force || true; apache2-foreground"
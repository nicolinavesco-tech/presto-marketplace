# Dockerfile (Laravel + Vite) per Render
FROM php:8.4-cli

# 1) Dipendenze di sistema + estensioni PHP
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif \
    && rm -rf /var/lib/apt/lists/*

# 2) Node.js (per Vite build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# 4) Installa dipendenze PHP PRIMA di copiare tutto il progetto
#    (Laravel scripts disabilitati perché artisan non esiste ancora)
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --no-scripts

# 5) Copia tutto il progetto
COPY . .

# 6) Permessi Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# 7) Ora che artisan esiste, possiamo completare autoload + package discover
#    (|| true per non bloccare la build se mancano env in fase build)
RUN composer dump-autoload -o
RUN php artisan package:discover --ansi || true

# 8) Storage link (non bloccare la build se fallisce)
RUN php artisan storage:link || true

# 9) Build frontend (Vite)
#    npm ci è più stabile se hai package-lock.json
RUN npm ci && npm run build

EXPOSE 10000

# 10) Avvio (Render imposta la variabile PORT)
CMD sh -c "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"
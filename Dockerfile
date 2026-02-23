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

# ✅ (AGGIUNTA) Impostazioni Apache utili per Laravel + asset
# - AllowOverride All per usare .htaccess di Laravel
# - Abilita headers/mime (a volte utile per svg/css/js)
RUN a2enmod headers mime \
 && printf '\n<Directory "/var/www/html/public">\n  AllowOverride All\n  Require all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

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

# ✅ (AGGIUNTA) Se non esiste .env in prod, Laravel può rompersi o non generare URL asset corretti
# Render spesso usa env vars, ma avere un .env aiuta alcune cose (fallback).
# Se NON vuoi crearne uno, lascia pure così.
RUN if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi

# 6) Dipendenze PHP (no-scripts per evitare sqlite/package:discover in build)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# Crea link storage pubblico
RUN php artisan storage:link || true

# 7) Build frontend (Vite) + check manifest
# Se hai package-lock.json => usa npm ci (consigliato)
RUN npm ci \
    && npm run build \
    && ls -la public || true \
    && ls -la public/build || true \
    && test -f public/build/manifest.json

# ✅ (AGGIUNTA) Permessi anche su public/storage (se esiste) e cache
RUN mkdir -p public/storage \
    && chown -R www-data:www-data public/storage || true

# 8) Permessi Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# ✅ (AGGIUNTA IMPORTANTISSIMA)
# NON usare migrate:fresh in produzione: ti cancella tutto ad ogni restart/deploy.
# Usa migrate --force (applica solo nuove migration).
# E poi cache config/routes/views (velocizza e stabilizza).
CMD sh -c "\
  php artisan key:generate --force || true; \
  php artisan migrate --force || true; \
  php artisan config:cache || true; \
  php artisan route:cache || true; \
  php artisan view:cache || true; \
  apache2-foreground"
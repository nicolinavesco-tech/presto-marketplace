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

# Crea link storage pubblico
RUN php artisan storage:link || true

# ✅ AGGIUNTA: pubblica gli asset dei pacchetti (bandiere) in public/vendor/...
# (metto più tentativi così copriamo tag diversi senza far fallire la build)
RUN php artisan vendor:publish --tag=blade-flags-assets --force || true \
 && php artisan vendor:publish --tag=blade-flags --force || true \
 && php artisan vendor:publish --tag=public --force || true \
 && ls -la public/vendor || true \
 && find public/vendor -maxdepth 3 -type f -name "country-*.svg" | head -n 20 || true

# 7) Build frontend (Vite) + check manifest
# Se hai package-lock.json => usa npm ci (consigliato)
RUN npm ci \
    && npm run build \
    && ls -la public || true \
    && ls -la public/build || true \
    && ls -la public/build/assets || true \
    && test -f public/build/manifest.json
  
# DEBUG: stampa contenuto build nei Build Logs (forza output anche se c'è cache)
RUN echo "==== DEBUG VITE BUILD FILES ====" \
 && pwd \
 && ls -la public || true \
 && ls -la public/build || true \
 && ls -la public/build/assets || true \
 && find public/build -maxdepth 2 -type f -print || true \
 && echo "==== END DEBUG ===="

# ✅ AGGIUNTA: verifica che ESISTANO davvero i file hashati (css/js) dentro assets
RUN find public/build/assets -maxdepth 1 -type f \( -name "*.css" -o -name "*.js" \) | head -n 50 || true

# 8) Permessi Laravel
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# ✅ AGGIUNTA: permessi anche per gli asset buildati (così Apache li serve sicuro)
RUN chown -R www-data:www-data public/build public/vendor || true \
    && chmod -R 755 public/build public/vendor || true

EXPOSE 80

# 9) Runtime: migrate (per Render free) + package discover + Apache
# ✅ AGGIUNTA: ripubblica bandiere + storage link anche a runtime (utile se Render resetta /public)
CMD sh -c "php artisan migrate:fresh --force; php artisan storage:link || true; php artisan vendor:publish --tag=blade-flags-assets --force || true; apache2-foreground"
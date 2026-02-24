FROM php:8.4-apache

# 1) System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libzip-dev \
    libpq-dev \
    libgd-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache config
RUN a2enmod rewrite

# ✅ FIX: Imposta il DocumentRoot DIRETTAMENTE (senza variabile d'ambiente)
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# ✅ FIX: Aggiungi anche il blocco Directory esplicito per /public
RUN echo '<Directory /var/www/html/public>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# 3) Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 4) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5) Copia progetto
COPY . .

# 6) Crea .env se non esiste (per artisan commands in build)
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate --force || true

# 7) Composer install
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts \
    && composer dump-autoload --optimize

# 8) Pubblica vendor assets (bandiere)
# ✅ FIX: eseguiamo PRIMA del build npm così Vite può includerli se necessario
RUN php artisan vendor:publish --tag=blade-flags-assets --force 2>/dev/null || true \
 && php artisan vendor:publish --tag=blade-flags --force 2>/dev/null || true \
 && php artisan vendor:publish --tag=public --force 2>/dev/null || true

# ✅ DEBUG: verifica dove sono finite le bandiere
RUN echo "=== BANDIERE PUBBLICATE ===" \
 && find public -name "country-*.svg" | head -20 || echo "NESSUNA BANDIERA TROVATA" \
 && echo "=== VENDOR DIR ===" \
 && ls -la public/vendor/ 2>/dev/null || echo "public/vendor non esiste"

# 9) Build frontend
RUN npm ci && npm run build

# ✅ DEBUG: verifica build Vite
RUN echo "=== VITE BUILD ===" \
 && ls -la public/build/ \
 && ls -la public/build/assets/ | head -20 \
 && cat public/build/manifest.json | head -20

# 10) Storage link
RUN php artisan storage:link || true

# 11) Permessi
RUN mkdir -p storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# 12) CMD runtime — NON ricostruire assets, solo migrate + apache
# ✅ FIX: rimosso vendor:publish dal CMD (i file devono già esistere dall'immagine)
CMD sh -c "\
    php artisan config:clear || true && \
    php artisan migrate --force || true && \
    apache2-foreground"
FROM php:8.4-apache

# 1) Dipendenze di sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpq-dev \
    gnupg \
    ca-certificates \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache: evita conflitti MPM e abilita rewrite
RUN a2dismod mpm_event || true \
    && a2dismod mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# 3) VirtualHost Apache puntato su /public
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    ServerName localhost' \
    '    DocumentRoot /var/www/html/public' \
    '' \
    '    <Directory /var/www/html/public>' \
    '        Options Indexes FollowSymLinks' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '' \
    '    ErrorLog ${APACHE_LOG_DIR}/error.log' \
    '    CustomLog ${APACHE_LOG_DIR}/access.log combined' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf

# 4) Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 5) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 6) Copia file progetto
COPY . .

# 7) Installazione dipendenze PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts

# 8) Copia manuale SVG bandiere
RUN mkdir -p public/vendor/blade-flags \
    && cp vendor/outhebox/blade-flags/resources/svg/*.svg public/vendor/blade-flags/ || true

# 9) Build frontend
RUN npm ci && npm run build

# 10) Link storage
RUN php artisan storage:link || true

# 11) Permessi
RUN mkdir -p storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# 12) Avvio container
CMD sh -c "\
    php artisan package:discover --ansi || true && \
    php artisan config:clear || true && \
    php artisan migrate --force || true && \
    apache2-foreground"
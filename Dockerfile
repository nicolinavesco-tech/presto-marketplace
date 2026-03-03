FROM php:8.4-apache

# 1) System deps + PHP extensions
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip exif \
    && rm -rf /var/lib/apt/lists/*

# 2) Apache config
RUN a2enmod rewrite headers
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
 && sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN printf '%s\n' \
  '<Directory /var/www/html/public>' \
  '    Options Indexes FollowSymLinks' \
  '    AllowOverride All' \
  '    Require all granted' \
  '</Directory>' \
  >> /etc/apache2/apache2.conf

# 3) Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# 4) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5) Copy project
COPY . .

# 6) Composer install (KEEP --no-scripts)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts \
 && composer dump-autoload -o

# 7) Copy SVG flags workaround
RUN mkdir -p public/vendor/blade-flags \
 && cp vendor/outhebox/blade-flags/resources/svg/*.svg public/vendor/blade-flags/ || true

# 8) Build frontend
RUN npm ci && npm run build

# 9) Storage link
RUN php artisan storage:link || true

# 10) Permissions
RUN mkdir -p storage/logs storage/app/public bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

# 11) Runtime (Render env variables are available here)
CMD sh -c "\
    php artisan package:discover --ansi && \
    php artisan optimize:clear || true && \
    php artisan migrate --force || true && \
    apache2-foreground"
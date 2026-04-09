# Stage 1: Build Front-end Assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Build PHP Dependencies
FROM composer:2.7 AS php-builder
WORKDIR /app
COPY composer.json composer.lock ./
# Installation sans dev et sans scripts pour l'instant
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize

# Stage 3: Production Image
FROM php:8.2-apache

# Installation des dépendances système (notamment SQLite et traitements images standard)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_sqlite gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Activation du module de réécriture d'URL Apache (indispensable pour Laravel)
RUN a2enmod rewrite

# Configuration du VirtualHost pour pointer sur le dossier public/ de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

# Import des builds
COPY --from=php-builder /app /var/www/html/
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Permisions & Propriétaires
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache database

# Setup Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Un script d'entrée automatique s'occupe de migrer la base
EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]


# Compilar CSS y JavaScript con Vite
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

# Ejecutar Laravel
FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev \
    libonig-dev libxml2-dev \
    && docker-php-ext-install \
    pdo_mysql mbstring zip intl \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY --from=frontend /app/public/build ./public/build

ENV PORT=10000
EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT}"]

FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader \
    --no-scripts

COPY . .
RUN cp .env.example .env \
    && php artisan package:discover --ansi \
    && rm .env

FROM node:20-bookworm-slim AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm run build

FROM php:8.3-apache-bookworm AS app

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        gettext-base \
        libicu-dev \
        libpq-dev \
        unzip \
    && docker-php-ext-install bcmath intl pdo_mysql pdo_pgsql \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app /var/www/html
COPY --from=assets /app/public/build /var/www/html/public/build
COPY docker/render/apache-site.conf.template /etc/apache2/sites-available/render.conf.template
COPY docker/render/start.sh /usr/local/bin/render-start

RUN chmod +x /usr/local/bin/render-start \
    && mkdir -p bootstrap/cache storage/framework/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && chown -R www-data:www-data bootstrap/cache storage

EXPOSE 10000

CMD ["render-start"]


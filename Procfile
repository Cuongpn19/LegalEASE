FROM php:8.2-fpm

WORKDIR /app

COPY . /app

# Cài extension
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip

# 🔴 BẮT BUỘC – TẠO THƯ MỤC TRƯỚC COMPOSER
RUN mkdir -p bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    && chmod -R 775 bootstrap/cache storage

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --ignore-platform-reqs --no-interaction --prefer-dist

# Nếu có frontend
RUN npm ci && npm run build

EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}

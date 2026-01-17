FROM php:8.2-fpm

WORKDIR /app

COPY . /app

# Cài system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip

# TẠO THƯ MỤC LARAVEL BẮT BUỘC
RUN mkdir -p bootstrap/cache storage/framework/cache \
    storage/framework/sessions storage/framework/views \
    storage/logs \
    && chmod -R 775 bootstrap/cache storage

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
FROM php:8.2-fpm

WORKDIR /app

COPY . /app

# Cài system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql zip

# TẠO THƯ MỤC LARAVEL BẮT BUỘC
RUN mkdir -p bootstrap/cache storage/framework/cache \
    storage/framework/sessions storage/framework/views \
    storage/logs \
    && chmod -R 775 bootstrap/cache storage

# Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}

FROM php:8.2-fpm

# 1. Cài đặt các thư viện hệ thống và extension PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    git \
    unzip \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# 2. Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Thiết lập thư mục làm việc
WORKDIR /app
COPY . .

# 4. TẠO THƯ MỤC VÀ CẤP QUYỀN TRƯỚC (Đây là bước sửa lỗi)
RUN mkdir -p storage/framework/cache/data \
    mkdir -p storage/framework/app/cache \
    mkdir -p storage/framework/sessions \
    mkdir -p storage/framework/views \
    mkdir -p storage/logs \
    mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /app/storage /app/bootstrap/cache \
    && chmod -R 775 /app/storage /app/bootstrap/cache

# 5. Cài đặt các thư viện PHP (Bây giờ script sẽ chạy thành công)
RUN composer install --no-dev --optimize-autoloader

# 6. Cấu hình cổng cho Railway
ENV PORT=8080
EXPOSE 8080

# 7. Lệnh khởi chạy
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8080

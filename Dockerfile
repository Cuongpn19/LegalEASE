FROM php:8.2-fpm

# Cài đặt các phần mở rộng cần thiết
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Cấu hình thư mục làm việc
WORKDIR /app
COPY . .

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Phân quyền cho Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Cổng mặc định
EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]

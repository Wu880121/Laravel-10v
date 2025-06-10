# 使用 PHP 8.2 + FPM 作為 base image
FROM php:8.2-fpm

# 安裝系統套件與 PHP 擴充
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

# 安裝 Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www/html

# 清除舊檔案（可選）
RUN rm -rf /var/www/html/*

# 複製 Laravel 專案原始碼（請搭配 .dockerignore）
COPY . .

# 安裝 Laravel 相依套件
RUN composer install --optimize-autoloader --no-dev

# Laravel 必要指令
RUN php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 修正權限（這次是有效的 RUN 區塊）
RUN chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# 啟動 php-fpm
CMD ["php-fpm"]

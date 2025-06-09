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

# ✅ 清除舊檔案（可選）
RUN rm -rf /var/www/html/*

# 複製專案檔案
#COPY . /var/www/html

# 設定權限(Windows沒辦法設定這指令，Linux才行)
# RUN chown -R www-data:www-data /var/www/html \
#    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 啟動 php-fpm
CMD ["php-fpm"]

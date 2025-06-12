# 使用 PHP 8.2 + FPM + Node 環境
FROM node:18-bullseye as nodebuild

# 建立 Vite build（包含 Laravel 的前端）
WORKDIR /app
COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# 第二階段：Laravel PHP App
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl bcmath

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/

COPY . .

# 將 Vite build 複製進來
COPY --from=nodebuild /app/public/build public/build

# 安裝 PHP 套件
RUN composer install --optimize-autoloader --no-dev

# 權限設定
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]

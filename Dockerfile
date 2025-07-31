FROM php:8.1-fpm-alpine

WORKDIR /var/www

# تثبيت الحزم الأساسية باستخدام apk
RUN apk add --no-cache \
    git openssh \
    libzip-dev libpng-dev libjpeg-turbo-dev \
    libxml2-dev \
    oniguruma-dev \
    sqlite-dev \
    unzip \
    curl \
    # تثبيت composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# تثبيت امتدادات PHP
RUN docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# نسخ ملفات المشروع
COPY . /var/www

# تثبيت حزم Laravel
RUN composer install --no-dev --optimize-autoloader

# إعداد الصلاحيات
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

CMD ["php-fpm"]

FROM php:8.1-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    zip unzip curl git libxml2-dev libzip-dev libpng-dev libjpeg-turbo-dev \
    sqlite sqlite-dev

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

COPY --chown=www-data:www-data . /var/www

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 755 /var/www
RUN composer install

COPY .env.example .env
RUN php artisan key:generate

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

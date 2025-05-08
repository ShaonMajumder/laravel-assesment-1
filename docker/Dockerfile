FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    libzip-dev \
    libssl-dev \
    redis-server \
    supervisor \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisord.conf /etc/supervisord.conf

RUN [ -d /var/www/html/storage ] && chown -R www-data:www-data /var/www/html/storage || echo "storage not found" && \
    [ -d /var/www/html/bootstrap/cache ] && chown -R www-data:www-data /var/www/html/bootstrap/cache || echo "cache not found" && \
    git config --global --add safe.directory /var/www/html
# for windows
# 0.484 fatal: detected dubious ownership in repository at '/var/www/html'
# 0.484 To add an exception for this directory, call:
# 0.484
# 0.484   git config --global --add safe.directory /var/www/html

# RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
#     && composer dump-autoload -o \
#     && php artisan package:discover
RUN if [ ! -f artisan ]; then \
    echo "Laravel not found. Creating in temp folder..."; \
    composer create-project --prefer-dist laravel/laravel /tmp/laravel; \
    cp -R /tmp/laravel/. .; \
    rm -rf /tmp/laravel; \
    fi \
    && composer install --no-interaction --prefer-dist --optimize-autoloader \
    && composer dump-autoload -o \
    && php artisan package:discover

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN php artisan key:generate

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]

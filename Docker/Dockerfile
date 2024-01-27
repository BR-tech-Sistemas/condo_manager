FROM php:8.3-fpm

RUN apt-get update && \
    apt-get install -y git zlib1g-dev libzip-dev unzip libicu-dev

RUN docker-php-ext-install pdo pdo_mysql zip intl

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

# Ajuste as permissões antes de copiar o código-fonte
RUN mkdir -p /var/www/html &&  \
    chown -R www-data:www-data /var/www/html

RUN mkdir -p /var/www/html/storage && \
    chown -R www-data:www-data /var/www/html/storage

WORKDIR /var/www/html

CMD ["php-fpm"]
EXPOSE 9000

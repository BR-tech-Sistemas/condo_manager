FROM php:8.3-cli

RUN apt-get update && \
    apt-get install -y git zlib1g-dev libzip-dev unzip libicu-dev

RUN docker-php-ext-install pdo pdo_mysql zip intl

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

COPY . /app

WORKDIR /app

CMD ["php"]

EXPOSE 8000
FROM dunglas/frankenphp:php8.4

ENV SERVER_NAME=":80"

WORKDIR /app

COPY . /app/

RUN apt update && apt install zip libzip-dev -y && \
    docker-php-ext-install zip pdo_mysql && \
    docker-php-ext-enable zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install
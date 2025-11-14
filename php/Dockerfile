FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip


RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

RUN chown -R www:www /var/www/html

USER www

EXPOSE 9000

CMD ["php-fpm"]
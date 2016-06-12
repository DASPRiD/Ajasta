FROM php:7.0-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

# Intall PHP dependencies
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y zlib1g-dev git && \
    rm -r /var/lib/apt/lists/*
RUN docker-php-ext-install bcmath pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install composer dependencies
COPY composer.json /tmp/composer.json
RUN cd /tmp && \
    composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
RUN mkdir -p /var/www/html && \
    cp -a /tmp/vendor /var/www/html/

# Copy nginx config
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Copy and chmod application
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

VOLUME ["/etc/nginx/conf.d"]
VOLUME ["/var/www/html"]


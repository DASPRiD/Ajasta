FROM php:7.0-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

# Intall application dependencies
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        git \
        npm \
        zlib1g-dev \
    && \
    rm -r /var/lib/apt/lists/*
RUN docker-php-ext-install bcmath pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN ln -s /usr/bin/nodejs /usr/bin/node
RUN npm install -g bower

# Install composer dependencies
RUN mkdir /tmp/composer
COPY composer.json /tmp/composer/composer.json
RUN cd /tmp/composer && \
    composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader
RUN mkdir -p /var/www/html && \
    cp -a /tmp/composer/vendor /var/www/html/

# Intall bower dependencies
RUN mkdir /tmp/bower
COPY bower.json /tmp/bower/bower.json
RUN cd /tmp/bower && \
    bower install --allow-root --no-color
RUN mkdir -p /var/www/html/public && \
    cp -a /tmp/bower/bower_components /var/www/html/public/vendor

# Copy nginx config
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

# Copy and chmod application
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

VOLUME ["/etc/nginx/conf.d"]
VOLUME ["/var/www/html"]

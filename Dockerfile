FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    && pecl install apcu \
    && docker-php-ext-enable \
    apcu

COPY apcu.ini /usr/local/etc/php/conf.d/apcu.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer
    
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
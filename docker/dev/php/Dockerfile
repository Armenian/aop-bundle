#https://olvlvl.com/2019-06-docker-pecl-without-pecl
FROM php:8.1-fpm

RUN apt update && apt install -y libicu-dev libpq-dev libpng-dev libfreetype6-dev libyaml-dev libjpeg-dev libwebp-dev libc-client-dev libkrb5-dev librabbitmq-dev \
    libjpeg62 libxtst6

COPY ./docker/dev/php/docker-php-ext-get /usr/local/bin/
RUN chmod 0755 /usr/local/bin/docker-php-ext-get

# renovate: datasource=github-tags depName=igbinary/igbinary versioning=semver
ENV PHP_IGBINARY_VERSION 3.2.7
# renovate: datasource=github-tags depName=phpredis/phpredis versioning=semver
ENV PHP_REDIS_VERSION 5.3.7
# renovate: datasource=github-tags depName=php-amqp/php-amqp versioning=semver
ENV PHP_AMQP_VERSION 1.11.0

RUN docker-php-source extract \
    # ext-opache
    && docker-php-ext-enable opcache \
    # ext-igbinary
    && docker-php-ext-get igbinary ${PHP_IGBINARY_VERSION} \
    && docker-php-ext-install igbinary \
    # ext-redis
    && docker-php-ext-get redis ${PHP_REDIS_VERSION} \
    && docker-php-ext-configure redis --enable-redis-igbinary \
    && docker-php-ext-install redis \
    # ext-apcu
    && docker-php-ext-get apcu 5.1.21 \
    && docker-php-ext-install apcu \
    # ext-yaml
    && docker-php-ext-get yaml 2.2.2 \
    && docker-php-ext-install yaml \
    # ext-json_post
    && docker-php-ext-get json_post 1.1.0 \
    && docker-php-ext-install json_post \
    # ext-amqp
    && docker-php-ext-get amqp ${PHP_AMQP_VERSION} \
    && docker-php-ext-install amqp \
    # ext-gd \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    # ext-imap \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install -j$(nproc) imap \
    # basic
    && docker-php-ext-install intl pdo pdo_pgsql pcntl  \
    # ext-xdebug \
    && docker-php-ext-get xdebug 3.0.4 \
    && docker-php-ext-install xdebug \
    ## cleanup
    && docker-php-source delete

# Dev

# composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

RUN apt update && apt install -y p7zip git unzip zip libzip-dev

RUN docker-php-source extract \
    # ext-xdebug \
    && docker-php-ext-get xdebug 3.0.4 \
    && docker-php-ext-install xdebug \
    # ext-zip
    && docker-php-ext-get zip 1.19.3 \
    && docker-php-ext-install zip \
    # ext-pcov
    && docker-php-ext-get pcov 1.0.10 \
    && docker-php-ext-install pcov \
    ## cleanup
    && docker-php-source delete


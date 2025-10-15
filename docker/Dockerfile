FROM php:8.1-fpm-alpine

ARG UID=${UID}
ARG GID=${GID}

RUN set -eux \
    && echo https://mirror.yandex.ru/mirrors/alpine/v3.21/community/ >> /etc/apk/repositories \
    && apk update \
    && apk upgrade \
    && apk add \
        ca-certificates \
        tzdata \
        wget \
    && update-ca-certificates \
    && apk add --virtual .build-deps $PHPIZE_DEPS git zip unzip zlib-dev coreutils \
    && : "---------- Imagemagick ----------" \
    && apk add --no-cache --virtual .imagick-build-dependencies imagemagick-dev \
    && apk add imagemagick freetype gettext \
    && git clone --depth=1 https://github.com/Imagick/imagick \
    && cd imagick \
    && phpize && ./configure \
    && make -j$(nproc) \
    && make install \
    && cd ../ \
    && rm -rf imagick \
    && docker-php-ext-enable imagick \
    && apk del .imagick-build-dependencies \
    && : "---------- GD ----------" \
    && apk add --no-cache --virtual .gd-build-dependencies freetype-dev libjpeg-turbo-dev libpng-dev vips-dev \
    && apk add vips \
    && docker-php-ext-configure gd --with-jpeg --with-freetype --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && apk del .gd-build-dependencies \
    && : "---------- DS ----------" \
    && pecl install ds \
    && docker-php-ext-enable ds \
    && : "---------- Redis ----------" \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && : "---------- Memcached ----------" \
    && apk add --no-cache --virtual .memcached-build-dependencies libmemcached-dev \
    && apk add libmemcached \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && apk del .memcached-build-dependencies \
    && : "---------- Postgres ----------" \
    && apk add --no-cache --virtual .postgresql-build-dependencies postgresql-dev \
    && apk add libpq \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && apk del .postgresql-build-dependencies \
    && : "---------- Exif ----------" \
    && docker-php-ext-install -j$(nproc) exif \
    && : "---------- Bcmath ----------" \
    && docker-php-ext-install -j$(nproc) bcmath \
    && : "---------- Opcache ----------" \
    && docker-php-ext-install -j$(nproc) opcache \
    && : "---------- Intl ----------" \
    && apk add icu-libs libintl \
    && apk add --no-cache --virtual .intl-build-dependencies icu-dev \
    && docker-php-ext-install -j$(nproc) intl \
    && apk del .intl-build-dependencies \
    && : "---------- Soap ----------" \
    && apk add --no-cache --virtual .soap-build-dependencies libxml2-dev \
    && docker-php-ext-install -j$(nproc) soap \
    && apk del .soap-build-dependencies \
    && : "---------- Zip ----------" \
    && apk add --no-cache --virtual .zip-build-dependencies libzip-dev \
    && apk add libzip \
    && docker-php-ext-install -j$(nproc) zip \
    && apk del .zip-build-dependencies \
    && : "---------- PCNTL ----------" \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-install pcntl \
    && : "---------- Cleanup ----------" \
    && apk del .build-deps \
    && docker-php-source delete \
    && rm -rf /var/cache/apk/* /var/tmp/* /tmp/*

 RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable pdo_mysql

RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

RUN apk update \
    && apk upgrade \
    && apk add --no-cache openssl \
    && apk add --no-cache bash \
    && apk add --no-cache supervisor

RUN apk add shadow &&  \
    usermod -u ${UID} www-data &&  \
    groupmod -g ${UID} www-data



WORKDIR /var/www

COPY "config/supervisor/supervisord.conf" "/etc/supervisord.conf"

ADD "config/crontab/crontab.txt" "/etc/cron.d/laravel-cron"
RUN chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron


RUN cd /usr/local/lib \
	&& wget https://composer.github.io/installer.sig -O - -q | tr -d '\n' > installer.sig \
	&& php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php -r "if (hash_file('SHA384', 'composer-setup.php') === file_get_contents('installer.sig')) { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
	&& php composer-setup.php \
	&& php -r "unlink('composer-setup.php'); unlink('installer.sig');" \
	&& mv /usr/local/lib/composer.phar /usr/local/bin/composer

EXPOSE 9000

ENTRYPOINT ["bash","./docker/start.sh"]

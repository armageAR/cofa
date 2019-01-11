FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    unzip
RUN docker-php-ext-configure zip --with-libzip
RUN docker-php-ext-install pdo_mysql zip

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd





RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# WORKDIR /usr/share/nginx/cofa/
# RUN chmod 777 /usr/share/nginx/cofa/storage/app/public
# RUN ln -s /usr/share/nginx/cofa/storage/app/public /usr/share/nginx/cofa/public/storage
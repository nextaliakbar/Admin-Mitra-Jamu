FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
  libpng-dev \
  zlib1g-dev \
  libxml2-dev \
  libpq-dev \
  libzip-dev \
  libonig-dev \
  zip \
  curl \
  unzip \
  && docker-php-ext-configure gd \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install pgsql \
  && docker-php-ext-install zip \
  && docker-php-source delete

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite

# install lets encrypt
RUN apt-get -y install certbot python3-certbot-apache

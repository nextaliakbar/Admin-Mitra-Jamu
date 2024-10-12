FROM php:8.2-fpm

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
  libpng-dev \
  zlib1g-dev \
  libxml2-dev \
  libpq-dev \
  libzip-dev \
  libonig-dev \
  libjpeg62-turbo-dev \
  libfreetype6-dev \
  build-essential \
  locales \
  jpegoptim optipng pngquant gifsicle \
  zip \
  vim \
  nano \
  git \
  unzip \
  curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-configure gd \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install pgsql \
  && docker-php-ext-install zip \
  && docker-php-source delete

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents to the working directory
# COPY . /var/www/

# Assign permissions of the working directory to the www-data user
# RUN chown -R www-data:www-data \
#   /var/www/storage \
#   /var/www/bootstrap/cache
COPY --chown=root:root . /var/www

RUN  chmod -R 777 /var/www/storage/ 
RUN  chmod -R 777 /var/www/bootstrap/cache/

# Change current user to www
# USER www-data

# Expose port 9000 and start php-fpm server (for FastCGI Process Manager)
EXPOSE 8013

# CMD ["php-fpm"]

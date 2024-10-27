FROM php:8.1.0-fpm

# Copy composer.lock and composer.json
# COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

#INSTALL dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    libonig-dev \
    curl \
    libcurl4-openssl-dev \
    pkg-config  \
    libssl-dev \
    nginx \
    procps \
    libicu-dev \
    acl \
    supervisor

RUN docker-php-ext-configure zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# install the PHP extensions we need (https://make.wordpress.org/hosting/handbook/handbook/server-environment/#php-extensions)
RUN docker-php-ext-install mbstring pdo pdo_mysql mysqli intl zip
RUN docker-php-ext-install bcmath pcntl
# RUN pecl install mongodb && echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
# RUN docker-php-ext-install pdo_mysql mbstring exif pcntl
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Configure Opcache
RUN docker-php-ext-configure opcache --enable-opcache && docker-php-ext-install opcache
# Configure Opcache

# # Install APCU
RUN pecl install apcu-5.1.21
RUN docker-php-ext-enable apcu opcache

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# ARG APCU_VERSION=5.1.11
# RUN apt-get install apcu-${APCU_VERSION} && docker-php-ext-enable apcu
# RUN php --info | grep apc
# # Install APCU

# Add user for laravel application
# RUN groupadd -g 1000 nginx
# RUN useradd -u 1000 -ms /bin/bash -g nginx nginx

# Copy existing application directory contents
COPY . /var/www/

ENV COMPOSER_ALLOW_SUPERUSER=1

# These are production settings, I'm running with 'no-dev', adjust accordingly
# if you need it
# RUN composer install

# RUN rm -rf /etc/nginx/sites-enabled/default
COPY nginx.conf /etc/nginx/sites-enabled/

RUN mkdir -p var
#Commenting for Kubernetes Deployment
RUN HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1) \
    && setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var \
    && setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var

RUN chown -R www-data:www-data var
RUN chown -R www-data:www-data /var/www/public/

# Copy existing application directory permissions
# COPY --chown=nginx:nginx . /var/www/

# Change current user to www
# USER nginx

# Expose port 9000 and start php-fpm server
#EXPOSE 9000
# CMD ["php-fpm"]
#CMD ["supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
#ENTRYPOINT ["sh", "/var/www/entrypoint.sh"]

CMD service nginx start && php-fpm
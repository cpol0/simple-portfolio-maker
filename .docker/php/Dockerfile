ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm

RUN apt-get update && apt-get install -y \ 
    build-essential libssl-dev zlib1g-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev unzip bash msmtp msmtp-mta mailutils 

RUN docker-php-ext-install mysqli pdo pdo_mysql zip

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd
    
RUN pecl install xdebug-2.9.8 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#Mail Server & Maildev
RUN echo "localhost localhost.localdomain" >> /etc/hosts
COPY msmtprc /etc/msmtprc
RUN chmod 600 /etc/msmtprc


RUN echo "localhost localhost.localdomain" >> /etc/hosts

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Install WP-CLI
RUN cd /tmp && echo "Installing WP-CLI" && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp
#COPY --from=wp /usr/local/bin/wp /usr/bin/wp


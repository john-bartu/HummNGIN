FROM php:8.0-fpm

# Mysql driver
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql

ARG WITH_XDEBUG=false


# Install xdebug and enable
RUN if [ $WITH_XDEBUG = "true" ] ; then \
            pecl install xdebug; \
            docker-php-ext-enable xdebug; \
    fi;

# Copy php configuration
COPY ./docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./docker/php/conf.d/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

# Copy the application code

COPY . /app

VOLUME ["/app"]

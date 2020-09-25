FROM php:7.4-apache

RUN cd /etc/apache2/mods-enabled && \
    ln -s ../mods-available/rewrite.load

# Install required PHP extensions
# -- GD
RUN apt-get update && \
    apt-get install -y libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ && \
    docker-php-ext-install -j$(nproc) gd

# -- mysql
RUN docker-php-ext-install -j$(nproc) mysql pdo_mysql

COPY 000-default.conf /etc/apache2/sites-available/
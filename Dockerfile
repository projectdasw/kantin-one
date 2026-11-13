FROM php:8.4-apache

# OPcache Configuration
COPY docker/php/conf.d/99-kantin-one-opcache.ini /usr/local/etc/php/conf.d/99-kantin-one-opcache.ini

# Security Hardening
COPY docker/php/conf.d/99-kantin-one-security.ini /usr/local/etc/php/conf.d/99-kantin-one-security.ini

# Apache MPM Prefork Configuration
COPY docker/apache/mpm_prefork.conf /etc/apache2/mods-available/mpm_prefork.conf

# Apache Global Configuration
COPY docker/apache/conf.d/99-kantin-one.conf /etc/apache2/conf-available/99-kantin-one.conf

RUN a2enconf 99-kantin-one

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    zip \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

FROM php:8.2-apache
WORKDIR /var/www/html

RUN apt-get update && \
    apt-get install -y libxslt1-dev && \
    docker-php-ext-install xsl

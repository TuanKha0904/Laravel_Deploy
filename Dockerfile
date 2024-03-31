FROM ubuntu:22.04 AS base

USER root
# Install dependencies
RUN apt update && apt install -y apache2

RUN apt install -y software-properties-common
RUN add-apt-repository -y ppa:ondrej/php
RUN apt update
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt install -y php8.2\
    php8.2-cli\
    php8.2-common\
    php8.2-fpm\
    php8.2-mysql\
    php8.2-zip\
    php8.2-gd\
    php8.2-mbstring\
    php8.2-curl\
    php8.2-xml\
    php8.2-bcmath\
    php8.2-pdo\
    curl\
    libapache2-mod-php8.2\
    && a2enmod rewrite && a2enmod php8.2


COPY apache.conf /etc/apache2/sites-available/apache.conf

RUN a2ensite apache.conf \
    && a2dissite 000-default.conf

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www/html

RUN composer install

RUN a2enmod ssl
COPY localhost.crt /etc/apache2/ssl/localhost.crt
COPY localhost.key /etc/apache2/ssl/localhost.key

EXPOSE 80 443

CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]

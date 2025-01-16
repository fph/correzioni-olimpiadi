# This is meant to be used via docker-compose.yml in the same directory
FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev zip
RUN docker-php-ext-install zip mysqli
WORKDIR /var/www
RUN curl -L https://github.com/PHPMailer/PHPMailer/archive/refs/heads/master.zip -o phpmailer.zip
RUN unzip phpmailer.zip && rm phpmailer.zip
WORKDIR /var/www/html

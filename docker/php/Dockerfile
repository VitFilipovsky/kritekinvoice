FROM php:8.4-apache
RUN apt-get update && apt upgrade -y
RUN apt-get install -y libzip-dev zip curl git libpng-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install mysqli pdo pdo_mysql zip gd
RUN docker-php-ext-enable pdo pdo_mysql mysqli
# Verify PDO MySQL is loaded (fail build if missing)
RUN php -m | grep -q pdo_mysql && php -m | grep -q PDO
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN service apache2 restart
WORKDIR /var/www/html
CMD ["apache2-foreground"]

FROM php:8.1-apache-bullseye
EXPOSE 80

# Install dependencies & extensions
RUN apt-get update
RUN apt-get install -y git zip unzip curl

RUN docker-php-ext-install pdo pdo_mysql
RUN a2enmod rewrite

# Copy application
COPY . /var/www
RUN chown -R www-data:www-data /var/www

# Run composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
WORKDIR /var/www

USER www-data
RUN composer install

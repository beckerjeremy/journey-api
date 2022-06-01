FROM php:8.0-apache
WORKDIR /var/www/html

# Install git
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git

# Copy apache config
COPY journey_api.conf /etc/apache2/sites-available/journey_api.conf

# Register page and restart apache
RUN a2ensite journey_api && a2enmod rewrite && service apache2 restart

# Install further php packages
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy all data and rewrite permissions
COPY . .
RUN chmod -R 777 /var/www/html &&\
    chgrp -R www-data /var/www/html/

# Install app
RUN composer update && composer install
COPY .env.example .env
EXPOSE 8000
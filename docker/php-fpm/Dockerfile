FROM php:fpm-alpine
RUN apk --update --no-cache add git
COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install --no-dev --optimize-autoloader ; /var/www/bin/console app:git-clone ; APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear ; php-fpm 
EXPOSE 9000

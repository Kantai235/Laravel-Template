FROM node:16-alpine AS npm-builder
WORKDIR /app
ADD . /app
RUN npm install && npm run production


FROM php:8.1-fpm AS production
WORKDIR /app
COPY --from=npm-builder /app/ /app/
RUN apt-get update -y && apt-get install -y unzip libzip-dev && rm -rf /var/lib/{apt,dpkg,cache,log}/ && docker-php-ext-install mysqli pdo pdo_mysql zip
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer install
RUN php artisan storage:link
ENTRYPOINT [ "/app/run.sh" ]

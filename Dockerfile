FROM richarvey/nginx-php-fpm:3.1.6

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

COPY nginx-site.conf /etc/nginx/sites-available/default.conf

RUN chown -R nginx:nginx /var/www/html/storage /var/www/html/bootstrap/cache

ENV WEBROOT=/var/www/html/public
ENV SKIP_COMPOSER=1

CMD php artisan migrate --force && /start.sh
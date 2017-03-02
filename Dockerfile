FROM php:5.6
RUN apt-get update && apt-get install -y git unzip zlib1g-dev mysql-client netcat
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
CMD cd /var/www/html/ && php composer.phar install && cp -R .env.docker .env \
    && while ! nc -zv v-test-db 3306; do sleep 1; done \
    && mysql -hv-test-db -uroot -pqwe123 -e 'create database v_test;' \
    && php artisan migrate && php artisan db:seed \
    && bin/run

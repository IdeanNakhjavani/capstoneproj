#start with base

#make sure to match same version of webserver
FROM php:8.1-fpm-alpine   
RUN docker-php-ext-install pdo pdo_mysql

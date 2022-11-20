#!/bin/sh

composer install --no-interaction

chown -R www-data var

exec docker-php-entrypoint "php-fpm"

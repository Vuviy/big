#!/usr/bin/env bash

sleep 2
composer install --no-progress --prefer-dist --working-dir=/var/www/html

php artisan key:generate
php artisan storage:link

#db container maybe is not start yet
#php artisan migrate --no-interaction

#php artisan db:seed

#ram volume not mounted yet
#sleep 2
#php artisan app:install --env=testing --force
#sleep 2
#php artisan migrate --no-interaction --env=testing
#sleep 5
#php artisan db:seed --env=testing
#sleep 10
#php artisan passport:install --env=testing
#sleep 2

exec php-fpm --nodaemonize

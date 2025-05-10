#!/bin/bash

# Executa migrações
php artisan migrate --force || true

# Gera APP_KEY se não existir
if [ ! -f /var/www/bootstrap/cache/app.php ]; then
    php artisan key:generate
fi

# Inicia PHP-FPM e Nginx
php-fpm -D
nginx -g "daemon off;"

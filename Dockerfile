FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    nginx \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    npm \
    nodejs \
    sqlite3 \
    libsqlite3-dev \
    supervisor 

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Gerar APP_KEY
# RUN php artisan key:generate

# Gera cache de configuração e realiza migrations
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && php artisan migrate --force || true

# Copia config do Nginx
COPY default.conf /etc/nginx/conf.d/default.conf

# Copia supervisord para gerenciar Nginx + PHP-FPM
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Define permissões corretas
RUN chown -R www-data:www-data storage bootstrap/cache

# Expõe porta
EXPOSE 80

# Comando final: inicia nginx + php-fpm via supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

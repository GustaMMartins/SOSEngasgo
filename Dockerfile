FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
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

# Gerar cache de configuração e rodar migrations
# RUN php artisan config:cache
# RUN php artisan migrate --force

# Copia config do Nginx
COPY default.conf /etc/nginx/conf.d/default.conf

# Define permissões corretas
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponha a porta 80 (Nginx usará)
EXPOSE 80

# Comando de entrada
CMD sleep 5 && \
    php artisan config:cache && \
    php artisan migrate --force && \
    php-fpm -D && \
    nginx -g "daemon off;"

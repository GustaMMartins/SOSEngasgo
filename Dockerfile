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
    libsqlite3-dev

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

# Rodar migrations
RUN php artisan migrate --force

# Ajustar permissões
RUN chown -R www-data:www-data storage bootstrap/cache

# Expor a porta e iniciar Laravel
EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000
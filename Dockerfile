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
    nodejs

# Instalar extensões PHP
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar arquivos da aplicação
WORKDIR /var/www
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Gerar APP_KEY
RUN php artisan key:generate

# Permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Rodar servidor embutido
CMD php artisan serve --host=0.0.0.0 --port=8080

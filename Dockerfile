# Imagen base
FROM php:8.2-apache

# Instala extensiones necesarias (pdo, pdo_mysql, etc.)
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la app
COPY . .

# Ejecuta Composer para instalar dependencias
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Habilita mod_rewrite si es necesario
RUN a2enmod rewrite

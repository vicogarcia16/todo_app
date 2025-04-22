# Imagen base con PHP 8.2 y Apache
FROM php:8.2-apache

# Habilita extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia el proyecto al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Da permisos a la carpeta si es necesario
RUN chown -R www-data:www-data /var/www/html

# Instala dependencias
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Expone el puerto 80
EXPOSE 80

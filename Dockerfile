# Imagen base con PHP y Apache
FROM php:8.2-apache

# Habilita extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instala Composer desde una imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia solo composer.json y composer.lock primero (mejora el caché de docker)
COPY composer.json composer.lock ./

# Ahora copia todo lo demás
COPY . .

# Da permisos al proyecto
# RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80

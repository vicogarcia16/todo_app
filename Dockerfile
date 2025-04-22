# Imagen base con PHP y Apache
FROM php:8.2-apache

# Instala extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_pgsql

# Instala herramientas adicionales (opcional pero útil)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Copia Composer desde la imagen oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . .

# Instala dependencias de Composer
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite

# Asegura que los permisos sean correctos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
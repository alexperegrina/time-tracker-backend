# Imagen base con PHP
FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    curl \
    netcat-openbsd \
    default-mysql-client \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

## Copiar el código fuente del proyecto
COPY . .

# Instalar dependencias de Symfony
RUN composer install --no-scripts --no-interaction --prefer-dist

# Asignar permisos a los archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto 9000 (por defecto en PHP-FPM)
EXPOSE 9000

COPY etc/docker/entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Comando de inicio
CMD ["php-fpm"]
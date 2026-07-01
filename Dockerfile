# Imagen ligera de PHP sin Apache
FROM php:8.2-cli

# Instalar extensión PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiar archivos del proyecto
COPY . /var/www/html/

WORKDIR /var/www/html

# Usar el servidor web integrado de PHP
# Railway asigna el puerto via variable $PORT
CMD php -S 0.0.0.0:${PORT:-8080} -t /var/www/html

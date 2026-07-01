# Imagen base: PHP 8.2 con Apache incluido
FROM php:8.2-apache

# Instalar las extensiones de MySQL que necesitamos (pdo_mysql)
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite para que funcione el .htaccess
RUN a2enmod rewrite

# Permitir que .htaccess sobreescriba la configuración de Apache
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copiar todos los archivos del proyecto al directorio público de Apache
COPY . /var/www/html/

# Dar permisos correctos al servidor web
RUN chown -R www-data:www-data /var/www/html

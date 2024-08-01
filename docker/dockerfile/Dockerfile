# Utilizar una imagen base de PHP con Apache
FROM php:8.0.0-apache

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql \
    && a2enmod rewrite

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Agregar ServerName a la configuración global de Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]

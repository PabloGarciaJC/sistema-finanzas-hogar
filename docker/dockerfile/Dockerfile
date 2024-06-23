# Utilizar una imagen base de PHP con Apache
FROM php:8.0.0-apache

# Definir el argumento PROJECT_PATH (se pasa desde docker-compose.yml)
ARG PROJECT_PATH

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql \
    && a2enmod rewrite

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]

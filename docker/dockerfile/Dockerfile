# Utilizar una imagen base de PHP con Apache
FROM php:8.0.0-apache

# Suprimir la interacción del usuario durante la instalación de paquetes
ARG DEBIAN_FRONTEND=noninteractive

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable mysqli pdo_mysql \
    && a2enmod rewrite

# Crear el directorio DocumentRoot si no existe
RUN mkdir -p /var/www/Portafolios/gestionhogar_pablogarciajc

# Copiar los archivos del directorio del proyecto al directorio de trabajo en el contenedor
COPY . /var/www/html

# Configurar Apache
COPY config/docker.conf /etc/apache2/sites-available/docker.conf
RUN a2enmod rewrite
RUN service apache2 restart

# Configurar ServerName globalmente para Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]

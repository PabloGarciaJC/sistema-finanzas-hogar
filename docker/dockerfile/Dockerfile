# Utilizamos una imagen base de PHP con Apache
FROM php:8.0.0-apache

# Suprimir la interacción del usuario durante la instalación de paquetes
ARG DEBIAN_FRONTEND=noninteractive

# Instala la extensión mysqli para la comunicación con MySQL
RUN docker-php-ext-install mysqli \
    # Actualiza la lista de paquetes disponibles
    && apt-get update \
    # Instala paquetes necesarios: sendmail, libpng-dev, libzip-dev, zlib1g-dev, libonig-dev
    && apt-get install -y sendmail libpng-dev libzip-dev zlib1g-dev libonig-dev \
    # Limpia la caché de paquetes descargados
    && rm -rf /var/lib/apt/lists/* \
    # Instala extensiones PHP: zip, mbstring, gd
    && docker-php-ext-install zip mbstring gd

# Habilitar el módulo rewrite de Apache
RUN a2enmod rewrite

# Establecer el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Copiar los archivos desde el directorio del proyecto al directorio de trabajo en el contenedora
COPY . .


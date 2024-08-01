# Utilizar una imagen base de PHP con Apache
FROM php:8.0.0-apache

# Habilitar mod_rewrite e instalar extensiones y librerías necesarias
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    libzip-dev && \
    docker-php-ext-install mysqli pdo_mysql && \
    docker-php-ext-enable mysqli pdo_mysql && \
    a2enmod rewrite
    
# Copiar el contenido de la aplicación
COPY . /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar extensiones PHP
RUN docker-php-ext-install gettext intl pdo_mysql gd

# Configurar la extensión GD
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Copiar y habilitar la configuración de Apache
COPY my_apache_config.conf /etc/apache2/sites-available/my_apache_config.conf
RUN a2ensite my_apache_config.conf
RUN a2dissite 000-default.conf

# Agregar ServerName a la configuración global de Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer el puerto 80
EXPOSE 80

# Comando por defecto
ENTRYPOINT ["docker-php-entrypoint"]
CMD ["apache2-foreground"]

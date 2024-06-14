#!/bin/bash
set -e

# Contraseña de MySQL
MYSQL_PASSWORD="password"

# Comandos SQL para crear la base de datos y usuario, y conceder privilegios
mysql -u root -p"$MYSQL_PASSWORD" <<-EOSQL
    CREATE DATABASE IF NOT EXISTS gestionhogar_pablogarciajc;
    CREATE USER IF NOT EXISTS 'pablogarciajcbd'@'%' IDENTIFIED BY '$MYSQL_PASSWORD';
    GRANT ALL PRIVILEGES ON *.* TO 'pablogarciajcbd'@'%' WITH GRANT OPTION;
    FLUSH PRIVILEGES;
EOSQL

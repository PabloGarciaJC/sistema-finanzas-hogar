# !/bin/bash
set -e

mysql -u root -ppassword <<-EOSQL
    CREATE DATABASE IF NOT EXISTS \`gestionhogar_pablogarciajc\`;
    CREATE USER IF NOT EXISTS 'pablogarciajcbd'@'%' IDENTIFIED BY 'password';
    GRANT ALL PRIVILEGES ON \`gestionhogar_pablogarciajc\`.* TO 'pablogarciajcbd'@'%' WITH GRANT OPTION;
    FLUSH PRIVILEGES;
EOSQL



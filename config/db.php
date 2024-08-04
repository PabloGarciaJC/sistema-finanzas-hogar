<?php

## ---------------------------------------------------------
## Mostrar todos los errores para depuración
## ---------------------------------------------------------

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

## ---------------------------------------------------------
## Clase para la Conexion a la base de datos
## ---------------------------------------------------------

class Database {
    static public function connect() {

        $db = new mysqli(DB_SERVER_NAME, DB_USER, DB_PASSWORD, DB_DATABASE, 3306);  

        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        } 

        $db->set_charset("utf8");

        return $db;
    }
}

Database::connect();
?>

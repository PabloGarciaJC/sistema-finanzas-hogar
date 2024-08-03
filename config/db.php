<?php
class Database {

    static public function connect(){
        echo "Intentando conectar a la base de datos...<br>";

        // Mostrar errores de PHP
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        // Intentar la conexión a la base de datos
        $db = new mysqli('127.0.0.1', 'u498565300_fzuserpjgc', 'iTdJM0k4w6c4qS', 'u498565300_fhbdpjgc', 3306);

        // Verificar conexión
        if ($db->connect_error) {
            echo "Error de conexión: " . $db->connect_error . "<br>";
            return null; // Salir si hay error de conexión
        }

        echo "Conexión exitosa a la base de datos.<br>";

        // Verificar si la conexión está activa
        if ($db->ping()) {
            echo "La conexión a la base de datos está activa.<br>";
        } else {
            echo "La conexión a la base de datos no está activa.<br>";
        }

        // Configurar charset
        if ($db->set_charset("utf8")) {
            echo "Charset configurado a utf8.<br>";
        } else {
            echo "Error configurando charset: " . $db->error . "<br>";
        }

        return $db;
    }
}

// Probar la conexión
Database::connect();

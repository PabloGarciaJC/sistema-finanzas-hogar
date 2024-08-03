<?php
class Database {

    static public function connect(){
        echo "Intentando conectar a la base de datos...<br>";

        $db = new mysqli('127.0.0.1', 'u498565300_fzuserpjgc', 'iTdJM0k4w6c4qS', 'u498565300_fhbdpjgc', 3306);

        if ($db->connect_error) {
            echo "Error de conexión: " . $db->connect_error . "<br>";
            return null; // Salir si hay error de conexión
        }

        echo "Conexión exitosa a la base de datos.<br>";
        
        if ($db->ping()) {
            echo "La conexión a la base de datos está activa.<br>";
        } else {
            echo "La conexión a la base de datos no está activa.<br>";
        }

        $db->set_charset("utf8");
        echo "Charset configurado a utf8.<br>";

        return $db;
    }
}

// Probar la conexión
Database::connect();

<?php
class Database {

    static public function connect(){
        // Conexión a la base de datos usando Docker Compose
        $db = new mysqli('mysql', DB_USER, DB_PASSWORD, DB_DATABASE);   
        
         // Verificar conexión
         if ($db->connect_error) {
            error_log("Error de conexión: " . $db->connect_error);
            die("Error de conexión. Verifica el log para más detalles.");
        } else {
            error_log("Conexión exitosa a la base de datos.");
        }

        $db->set_charset("utf8");

        return $db;
    }
}

// Prueba la conexión
Database::connect();



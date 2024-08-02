<?php
class Database {

    static public function connect(){

         // Verificar y registrar variables de entorno
         error_log("DB_USER: " . (defined('DB_USER') ? DB_USER : 'No definido'));
         error_log("DB_PASSWORD: " . (defined('DB_PASSWORD') ? 'Definido' : 'No definido'));
         error_log("DB_DATABASE: " . (defined('DB_DATABASE') ? DB_DATABASE : 'No definido'));
         
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



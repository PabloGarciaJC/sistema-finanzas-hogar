<?php
class Database {

    static public function connect(){
        // Conexión a la base de datos usando Docker Compose
        $db = new mysqli('mysql', DB_USER, DB_PASSWORD, DB_DATABASE);   
        
        // Verificar conexión
        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        }
        
        $db->set_charset("utf8");

        return $db;
    }
}

// Ejemplo de uso:
// $tes = Database::connect();


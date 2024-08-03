<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {
    static public function connect() {

        // Crear conexión
        $db = new mysqli(DB_SERVER_NAME, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);

        // Verificar conexión
        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        } else {
            // echo "Conexión exitosa a la base de datos.";
        }

        // Establecer el conjunto de caracteres
        $db->set_charset("utf8");

        return $db;
    }
}

// Probar la conexión
Database::connect();
?>

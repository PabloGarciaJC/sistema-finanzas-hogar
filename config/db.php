<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {
    static public function connect() {
        // Datos de conexión
        $servername = '127.0.0.1';
        $username = 'u498565300_fzuserpjgc';
        $password = 'S9FD=A~2h>'; // La nueva contraseña
        $dbname = 'u498565300_fhbdpjgc';
        $port = 3306; // Puerto de la base de datos (ajústalo si es diferente)

        // Crear conexión
        $db = new mysqli($servername, $username, $password, $dbname, $port);

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

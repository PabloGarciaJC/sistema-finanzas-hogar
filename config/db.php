<?php
class Database {
    static public function connect() {
        $db = new mysqli('127.0.0.1', 'u498565300_fzuserpjgc', 'iTdJM0k4w6c4qS', 'u498565300_fhbdpjgc', 3306);

        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        } else {
            echo "Conexión exitosa a la base de datos.";
        }

        $db->set_charset("utf8");

        return $db;
    }
}

Database::connect();
?>

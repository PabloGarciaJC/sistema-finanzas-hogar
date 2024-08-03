<?php
class Database {

    private static $logger;

    static public function connect(){

        if (self::$logger === null) {
            self::$logger = LoggerWrapper::getInstance();
        }
        self::$logger->info(DB_USER);

        // Conexión a la base de datos usando Docker Compose
        $db = new mysqli('127.0.0.1', 'u498565300_fzuserpjgc', 'iTdJM0k4w6c4qS', 'u498565300_fhbdpjgc', 3306);
        
        // Verificar conexión
        if ($db->connect_error) {
            // self::$logger->info("Error de conexión: " . $db->connect_error);
        } else {
            // self::$logger->info("Conexión exitosa a la base de datos.");
        }

        $db->set_charset("utf8");

        return $db;

        

    }

    
}



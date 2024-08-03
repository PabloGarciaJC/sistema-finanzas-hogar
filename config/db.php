<?php
class Database {

    private static $logger;

    static public function connect(){

        if (self::$logger === null) {
            self::$logger = LoggerWrapper::getInstance();
        }
        self::$logger->info(DB_DATABASE);

        // Conexión a la base de datos usando Docker Compose
        $db = new mysqli('mysql', 'u498565300', 'iTdJM0k4w6c4qS', 'u498565300_fhbdpjgc');   
       
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



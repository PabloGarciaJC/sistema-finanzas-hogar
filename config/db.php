<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database {

    private static $logger;

    public function __construct()
    {
        // No es necesario en este caso, ya que estamos usando el método estático
    }

    static public function initLogger() {
        self::$logger = LoggerWrapper::getInstance();
    }

    static public function connect() {
        // Asegúrate de haber inicializado el logger
        if (self::$logger === null) {
            self::initLogger();
        }

        // Crear conexión
        $db = new mysqli(DB_SERVER_NAME, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);

        // Verificar conexión
        if ($db->connect_error) {
            die("Error de conexión: " . $db->connect_error);
        } else {
            // Usar el logger estático
            self::$logger->info('Conexión exitosa a la base de datos.');
        }

        // Establecer el conjunto de caracteres
        $db->set_charset("utf8");

        return $db;
    }
}

// Inicializar el logger
Database::initLogger();

// Probar la conexión
Database::connect();
?>

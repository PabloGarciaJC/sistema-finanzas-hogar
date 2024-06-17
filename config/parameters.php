<?php

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('./docker/');
$dotenv->load();

// Bases de Datos
define("DB_USER", $_ENV['MYSQL_USER']);
define("DB_PASSWORD", $_ENV['MYSQL_PASSWORD']);
define("DB_DATABASE", $_ENV['COMPOSE_PROJECT_NAME']);
// Action es el Metodo de los Controladores
define("CONTROLLER_DEFAULT", "RegistroController");
define("ACTION_DEFAULT", "index"); 
define("BASE_URL","http://localhost:8082/");
?>


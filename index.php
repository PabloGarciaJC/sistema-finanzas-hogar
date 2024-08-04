<?php

session_start();

## ---------------------------------------------------------
## Cargar variables de entorno
## ---------------------------------------------------------

require_once __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ );
$dotenv->load();

## ---------------------------------------------------------
## Incluir archivos de configuración y librerías
## ---------------------------------------------------------

require_once __DIR__ . '/config/includes.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/helpers/registro/htmlRegistro.php';
require_once __DIR__ . '/helpers/registro/validaciones.php';
require_once __DIR__ . '/helpers/configuracion/htmlConfiguracion.php';
require_once __DIR__ . '/helpers/configuracion/validacionesConfig.php';
require_once __DIR__ . '/helpers/historial/estadisticas.php';
require_once __DIR__ . '/helpers/configuracion/estadisticasConfig.php';
require_once __DIR__ . '/helpers/historial/htmlHistorial.php';

## ---------------------------------------------------------
## Controlador Frontal
## ---------------------------------------------------------

if (isset($_GET['controller'])) {
   $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
   $nombre_controlador = CONTROLLER_DEFAULT;
} else {
   $error = new ErrorController();
   $error->index();
   exit();
}

if (class_exists($nombre_controlador)) {
   $controlador = new $nombre_controlador;
   if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
      $action = $_GET['action'];
      $controlador->$action();
   } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
      $ACTION_DEFAULT = ACTION_DEFAULT;
      $controlador->$ACTION_DEFAULT();
   } else {
      $error = new ErrorController();
      $error->index();
   }
} else {
   $error = new ErrorController();
   $error->index();
}

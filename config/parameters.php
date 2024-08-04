<?php

## ---------------------------------------------------------
## Definición de constantes para bases de datos
## ---------------------------------------------------------

define("ACTION_DEFAULT", "index"); 
define("BASE_URL", $_ENV['BASE_URL_PROJECT']); 
define("CONTROLLER_DEFAULT", "RegistroController");
define("DB_USER", $_ENV['MYSQL_USER']);
define("DB_PASSWORD", $_ENV['MYSQL_PASSWORD']);
define("DB_DATABASE", $_ENV['DB_DATABASE']);
define("DB_SERVER_NAME", $_ENV['DB_SERVER_NAME']);
?>


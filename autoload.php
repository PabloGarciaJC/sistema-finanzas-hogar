<?php
spl_autoload_register(function($class) {
    $className = ucfirst($class); // Convertir la primera letra en mayúscula   
    $classPath = __DIR__ . '/controllers/' . $className . '.php'; // Ruta a los controladores
    if (file_exists($classPath)) {
        include $classPath;
    } else {
        echo "Error: No se pudo encontrar la clase '$className'";
    }
});

<?php
spl_autoload_register(function($class) {
    $className = ucfirst($class);
    $classPath = __DIR__ . '/controllers/' . $className . '.php';
    if (file_exists($classPath)) {
        include $classPath;
    } else {
        echo "Error: No se pudo encontrar la clase '$className'";
    }
});

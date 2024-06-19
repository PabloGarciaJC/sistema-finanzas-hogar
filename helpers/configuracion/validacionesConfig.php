<?php

class ValidacionesConfig
{
  public static function formConfig($descripcionConfig, $gastosConfig, $fechaCorteConfig)
  {
    $erroresConfig = [];

    if (empty($descripcionConfig)) {
      echo $errores['descripcionConfig'] = "error, vacio descripcionConfig. </br>";
    } elseif (is_numeric($descripcionConfig)) {
      echo $errores['descripcionConfig'] = "error, no es texto descripcionConfig.</br>";
    }

    if (!is_numeric($gastosConfig)) {
      echo $errores['gastosConfig'] = "error, no es numerico gastosConfig. </br>";
    }

    if (empty($fechaCorteConfig)) {
      echo $errores['fechaCorteConfig'] = "error, vacio fechaCorteConfig. </br>";
    } elseif (is_numeric($fechaCorteConfig)) {
      echo $errores['fechaCorteConfig'] = "error, no es texto fechaCorteConfig.</br>";
    }

    return count($erroresConfig);
  }


  public static function mensajeError($idInput, $mensaje)
  {
    return "<script>document.getElementById('$idInput').innerHTML='<strong>Error,</strong> $mensaje';</script>";
  }

  public static function alertErrorRegistro()
  {
    echo "<script>  Swal.fire ({title: 'El mes y año, ya estan registrados !!'})</script>";
  }
}

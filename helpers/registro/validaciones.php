<?php

class Validaciones
{
  public static function form($ingresoVeronica, $ingresoPablo, $ingresoExtra, $ahorrosVerpa, $mes, $year)
  {
    $errores = [];

    if (!is_numeric($ingresoVeronica)) {
      echo $errores['ingresoVeronica'] = "error, no es numerico ingresoVeronica. </br>";
    }

    if (!is_numeric($ingresoPablo)) {
      echo $errores['ingresoPablo'] = "error, no es numerico ingresoPablo. </br>";
    }

    if (!is_numeric($ingresoExtra)) {
      echo $errores['ingresoExtra'] = "error, no es numerico ingresoExtra.</br>";
    }

    if (!is_numeric($ahorrosVerpa)) {
      echo $errores['ahorrosVerpa'] = "error, no es numerico AhorrosVerpa. </br>";
    }

    if (empty($mes)) {
      echo $errores['mes'] = "error, vacio mes. </br>";
    } elseif (is_numeric($mes)) {
      echo $errores['mes'] = "error, no es texto mes.</br>";
    }

    if (!is_numeric($year)) {
      echo $errores['year'] = "error, no es numerico year. </br>";
    }

    return count($errores);
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

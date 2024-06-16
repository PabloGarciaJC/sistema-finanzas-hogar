<?php
require_once 'model/Registro.php';

class RegistroController
{
  public function index()
  {
    require_once 'views/layout/header.php';
    require_once 'views/registro/banner.php';
    require_once 'views/layout/sidebar.php';
    require_once 'views/registro/list.php';
    require_once 'views/layout/footer.php';
  }

  public function buscador()
  {
    $imputBuscador = isset($_POST["imputBuscador"]) ? $_POST["imputBuscador"] : false;
    $paginaActual = isset($_POST['paginaActual']) ? $_POST['paginaActual'] : false;
    htmlRegistro::obtenerTodos($imputBuscador, $paginaActual);
  }

  public function crear()
  {
    $ingresoVeronica = isset($_POST["ingresoVeronica"]) ? $_POST["ingresoVeronica"] : false;
    $ingresoPablo = isset($_POST["ingresoPablo"]) ? $_POST["ingresoPablo"] : false;
    $ingresoExtra = isset($_POST["ingresoExtra"]) ? $_POST["ingresoExtra"] : false;
    $ahorrosVerpa = isset($_POST["ahorros"]) ? $_POST["ahorros"] : false;
    $mes = isset($_POST["mes"]) ? $_POST["mes"] : false;
    $year = isset($_POST["year"]) ? $_POST["year"] : false;

    $registro = new Registro();
    $registro->setIngresoVeronica($ingresoVeronica);
    $registro->setIngresoPablo($ingresoPablo);
    $registro->setIngresoExtra($ingresoExtra);
    $registro->setSavingVerpa($ahorrosVerpa);
    $registro->setMes($mes);
    $registro->setYear($year);

    $validacionesErrores = Validaciones::form($ingresoVeronica, $ingresoPablo, $ingresoExtra, $ahorrosVerpa, $mes, $year);

    if ($validacionesErrores == 0) {
      $guardar = $registro->guardar();
      if ($guardar) {
        echo $guardar;
      }
    }
  }

  public function editar()
  {
    $id = isset($_POST["id"]) ? $_POST["id"] : false;
    $ingresoVeronica = isset($_POST["ingresoVeronica"]) ? $_POST["ingresoVeronica"] : false;
    $ingresoPablo = isset($_POST["ingresoPablo"]) ? $_POST["ingresoPablo"] : false;
    $ingresoExtra = isset($_POST["ingresoExtra"]) ? $_POST["ingresoExtra"] : false;
    $ahorrosVerpa = isset($_POST["ahorros"]) ? $_POST["ahorros"] : false;
    $mes = isset($_POST["mes"]) ? $_POST["mes"] : false;
    $year = isset($_POST["year"]) ? $_POST["year"] : false;

    $registro = new Registro();
    $registro->setId($id);
    $registro->setIngresoVeronica($ingresoVeronica);
    $registro->setIngresoPablo($ingresoPablo);
    $registro->setIngresoExtra($ingresoExtra);
    $registro->setSavingVerpa($ahorrosVerpa);
    $registro->setMes($mes);
    $registro->setYear($year);

    $validacionesErrores = Validaciones::form($ingresoVeronica, $ingresoPablo, $ingresoExtra, $ahorrosVerpa, $mes, $year);

    if ($validacionesErrores == 0) {
      $editar = $registro->edit();
      if ($editar) {
        echo $editar;
      }
    }
  }

  public function eliminar()
  {
    $id = isset($_POST["id"]) ? $_POST["id"] : false;

    $registro = new registro();
    $registro->setId($id);

    $eliminado = $registro->delete();

    if ($eliminado) {
      echo $eliminado;
    }
  }
  
}

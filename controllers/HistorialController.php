<?php

require_once 'model/historial.php';
require_once 'model/configuracion.php';

class HistorialController
{

    public function index()
    {
        $configuracion = new Configuracion();
        $mostarConfig = $configuracion->mostrar();
        $idRegistro = isset($_GET['id']) ? $_GET['id'] : false;
        require_once 'views/layout/header.php';
        require_once 'views/historial/banner.php';
        require_once 'views/layout/sidebar.php';
        require_once 'views/historial/list.php';
        require_once 'views/layout/footer.php';
    }

    public function buscador()
    {
        $imputBuscador = isset($_POST["imputBuscadorHistorial"]) ? $_POST["imputBuscadorHistorial"] : false;
        $paginaActualHistorial = isset($_POST['paginaActualHistorial']) ? $_POST['paginaActualHistorial'] : false;
        $idRegistro = isset($_POST["idRegistro"]) ? $_POST["idRegistro"] : false;
        htmlHistorial::obtenerTodos($imputBuscador, $paginaActualHistorial, $idRegistro);
    }

    public function crear()
    {
        $nombreHistorial = isset($_POST["nombreHistorial"]) ? $_POST["nombreHistorial"] : false;
        $descripcionHistorial = isset($_POST["descripcionHistorial"]) ? $_POST["descripcionHistorial"] : false;
        $gastosHistorial = isset($_POST["gastosHistorial"]) ? $_POST["gastosHistorial"] : false;
        $fechaCorteHistorial = isset($_POST["fechaCorteHistorial"]) ? $_POST["fechaCorteHistorial"] : false;
        $statusCrearHistorial = isset($_POST["statusCrearHistorial"]) ? $_POST["statusCrearHistorial"] : false;
        $idRegistro = isset($_POST["idRegistro"]) ? $_POST["idRegistro"] : false;

        $historial = new Historial();
        $historial->setNombre($nombreHistorial);
        $historial->setDescripcion($descripcionHistorial);
        $historial->setGastos($gastosHistorial);
        $historial->setFechaCorte($fechaCorteHistorial);
        $historial->setStatus($statusCrearHistorial);
        $historial->setIdRegistro($idRegistro);

        $validaciones = ValidacionesConfig::formConfig($descripcionHistorial, $gastosHistorial, $fechaCorteHistorial);

        if ($validaciones == 0) {

            $guardar = $historial->guardar();

            if ($guardar) {
                echo $guardar;
            }
        }
    }

    public function editar()
    {
        $idHistorial = isset($_POST["idHistorial"]) ? $_POST["idHistorial"] : false;
        $nombreHistorial = isset($_POST["nombreHistorial"]) ? $_POST["nombreHistorial"] : false;
        $descripcionHistorial = isset($_POST["descripcionHistorial"]) ? $_POST["descripcionHistorial"] : false;
        $gastosHistorial = isset($_POST["gastosHistorial"]) ? $_POST["gastosHistorial"] : false;
        $fechaCorteHistorial = isset($_POST["fechaCorteHistorial"]) ? $_POST["fechaCorteHistorial"] : false;
        $statusHistorial = isset($_POST["statusHistorial"]) ? $_POST["statusHistorial"] : false;
        $idEditRegistro = isset($_POST["idEditRegistro"]) ? $_POST["idEditRegistro"] : false;

        $historial = new Historial();
        $historial->setId($idHistorial);
        $historial->setNombre($nombreHistorial);
        $historial->setDescripcion($descripcionHistorial);
        $historial->setGastos($gastosHistorial);
        $historial->setFechaCorte($fechaCorteHistorial);
        $historial->setStatus($statusHistorial);
        $historial->setIdRegistro($idEditRegistro);

        $validacionesErroresHistorial = ValidacionesConfig::formConfig($descripcionHistorial, $gastosHistorial, $fechaCorteHistorial);

        if ($validacionesErroresHistorial == 0) {

            $editar = $historial->editar();

            if ($editar) {
                echo $editar;
            }
        }
    }

    public function eliminar()
    {
        $idEliminarHistorial = isset($_POST["eliminarIdHistorial"]) ? $_POST["eliminarIdHistorial"] : false;

        $historial = new Historial();

        $historial->setId($idEliminarHistorial);

        $eliminado = $historial->delete();
        if ($eliminado == 1) {
            echo $eliminado;
        }
    }

    public function repoblar()
    {
        $idRegistro = isset($_POST["idRegistro"]) ? $_POST["idRegistro"] : false;

        $configuracion = new Configuracion();
        $guardado = $configuracion->repoblar();

        $historial = new Historial();
        $historial->setIdRegistro($idRegistro);

        $listarPorRol = $historial->mostrarPorRol();
        
        $historial->editarPorRol();
    }
}

<?php

require_once 'model/Configuracion.php';

class ConfiguracionController
{
    private $logger;

    public function __construct()
    {
        $this->logger = LoggerWrapper::getInstance();
    }

    public function index()
    {

    
        $this->logger->info('Entrando al método index de ConfiguracionController');
        require_once 'views/layout/header.php';
        require_once 'views/configuracion/banner.php';
        require_once 'views/layout/sidebar.php';
        require_once 'views/configuracion/list.php';
        require_once 'views/layout/footer.php';
    }

    public function buscador()
    {
        $imputBuscador = isset($_POST["imputBuscadorConfig"]) ? $_POST["imputBuscadorConfig"] : false;
        $paginaActual = isset($_POST['paginaActualConfig']) ? $_POST['paginaActualConfig'] : false;
        $repoblar = isset($_POST["repoblar"]) ? $_POST["repoblar"] : false;
        htmlConfiguracion::obtenerTodos($imputBuscador, $paginaActual);
    }

    public function crear()
    {
        $nombreConfig = isset($_POST["nombreConfig"]) ? $_POST["nombreConfig"] : false;
        $descripcionConfig = isset($_POST["descripcionConfig"]) ? $_POST["descripcionConfig"] : false;
        $gastosConfig = isset($_POST["gastosConfig"]) ? $_POST["gastosConfig"] : false;
        $fechaCorteConfig = isset($_POST["fechaCorteConfig"]) ? $_POST["fechaCorteConfig"] : false;
        $statusCrearConfig = isset($_POST["statusCrearConfig"]) ? $_POST["statusCrearConfig"] : false;

        $configuracion = new Configuracion();
        $configuracion->setNombre($nombreConfig);
        $configuracion->setDescripcion($descripcionConfig);
        $configuracion->setGastos($gastosConfig);
        $configuracion->setFechaCorte($fechaCorteConfig);
        $configuracion->setStatus($statusCrearConfig);

        $validacionesErroresConfig = ValidacionesConfig::formConfig($descripcionConfig, $gastosConfig, $fechaCorteConfig);

        if ($validacionesErroresConfig == 0) {

            $guardar = $configuracion->guardar();

            if ($guardar) {
                echo $guardar;
            }
        }
    }

    public function editar()
    {
        $idConfig = isset($_POST["idConfig"]) ? $_POST["idConfig"] : false;
        $nombreConfig = isset($_POST["nombreConfig"]) ? $_POST["nombreConfig"] : false;
        $descripcionConfig = isset($_POST["descripcionConfig"]) ? $_POST["descripcionConfig"] : false;
        $gastosConfig = isset($_POST["gastosConfig"]) ? $_POST["gastosConfig"] : false;
        $fechaCorteConfig = isset($_POST["fechaCorteConfig"]) ? $_POST["fechaCorteConfig"] : false;
        $statusConfig = isset($_POST["statusConfig"]) ? $_POST["statusConfig"] : false;

        $configuracion = new Configuracion();
        $configuracion->setId($idConfig);
        $configuracion->setNombre($nombreConfig);
        $configuracion->setDescripcion($descripcionConfig);
        $configuracion->setGastos($gastosConfig);
        $configuracion->setFechaCorte($fechaCorteConfig);
        $configuracion->setStatus($statusConfig);

        $validacionesErroresConfig = ValidacionesConfig::formConfig($descripcionConfig, $gastosConfig, $fechaCorteConfig);

        if ($validacionesErroresConfig == 0) {
            $editar = $configuracion->editar();
            if ($editar) {
                echo $editar;
            }
        }
    }

    public function eliminar()
    {
        $idEliminarConfig = isset($_POST["idEliminarConfig"]) ? $_POST["idEliminarConfig"] : false;

        $configuracion = new Configuracion();
        $configuracion->setId($idEliminarConfig);

        $eliminado = $configuracion->delete();
        if ($eliminado == 1) {
            echo $eliminado;
        }
    }
}

<?php
class Historial
{
    private $id;
    private $idRegistro;
    private $nombre;
    private $descripcion;
    private $gastos;
    private $fechaCorte;
    private $status;
    private $buscador;
    private $db;

    // CONSTRUCTOR
    public function __construct()
    {
        $this->db = Database::connect();
    }

    // SETTER
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdRegistro($idRegistro)
    {
        $this->idRegistro = $idRegistro;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setGastos($gastos)
    {
        $this->gastos = $gastos;
    }

    public function setFechaCorte($fechaCorte)
    {
        $this->fechaCorte = $fechaCorte;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setBuscador($buscador)
    {
        $this->buscador = $buscador;
    }

    // GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getIdRegistro()
    {
        return $this->idRegistro;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getGastos()
    {
        return $this->gastos;
    }

    public function getFechaCorte()
    {
        return $this->fechaCorte;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getBuscador()
    {
        return $this->buscador;
    }

    //CODIGO SQL

    public function guardar()
    {
        $sql = "INSERT INTO historial (nombre,descripcion,gastos,fechaCorte,status,idRegister, rol) VALUES ('{$this->nombre}','{$this->descripcion}', {$this->gastos}, '{$this->fechaCorte}', '{$this->status}', '{$this->idRegistro}', 0)";

        $save = $this->db->query($sql);

        if ($save) {
            echo 1;
        }
    }

    public function listar($ultimoRegistro, $mostrarRegistros)
    {
        $sql = "SELECT * FROM historial c ";
        if ($this->getBuscador() == '') {
            $sql .= "WHERE idRegister = {$this->getIdRegistro()} AND rol = 0 ORDER BY FIELD (nombre,'Carrefour','Servicios','Deudas') ASC ";
        } else {
            $sql .= "WHERE (c.nombre LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.descripcion LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.gastos LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.fechaCorte LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.status LIKE '%{$this->getBuscador()}%') AND idRegister = {$this->getIdRegistro()} AND rol = 0 ";
            $sql .= "ORDER BY c.id DESC ";
        }


        $sql .= "LIMIT $ultimoRegistro, $mostrarRegistros;";

        $listar = $this->db->query($sql);
        return $listar;
    }

    public function conteoRegistros()
    {
        $sql = "SELECT count(c.id) as 'registrosTotales' FROM historial c ";

        if ($this->getBuscador() == '') {

            $sql .= "WHERE (idRegister = {$this->getIdRegistro()}) AND rol = 0 ORDER BY FIELD (nombre,'Carrefour','Servicios','Deudas') ASC ";
        } else {

            $sql .= "WHERE (c.nombre LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.descripcion LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.gastos LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.fechaCorte LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.status LIKE '%{$this->getBuscador()}%') AND idRegister = {$this->getIdRegistro()} AND rol = 0 ";
            $sql .= "ORDER BY c.id DESC ";
        }

        $listar = $this->db->query($sql);
        $obtener = $listar->fetch_object();
        $conteo = $obtener->registrosTotales;

        return $conteo;
    }

    public function editar()
    {
        $sql = "UPDATE historial SET "
            . "nombre= '{$this->nombre}', "
            . "descripcion= '{$this->descripcion}', "
            . "gastos={$this->gastos}, "
            . "fechaCorte='{$this->fechaCorte}', "
            . "status = '{$this->status}', "
            . "rol = 0 "
            . "WHERE id= {$this->id};";

        $save = $this->db->query($sql);

        if ($save) {
            echo 1;
        }
    }

    public function mostrarPorRol()
    {
        $sql = "SELECT * FROM historial WHERE rol = 1";
        $mostrar = $this->db->query($sql);
        return $mostrar;
    }


    public function editarPorRol()
    {
        $sql = "UPDATE historial SET idRegister = {$this->idRegistro}, rol = 0 WHERE rol = 1;";
        $save = $this->db->query($sql);
        if ($save) {
            echo 1;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM historial WHERE id = {$this->id}";

        $delete = $this->db->query($sql);

        if ($delete) {
            echo 1;
        }
    }

    public function mostrarRegistrosRol()
    {
        $sql = "SELECT * FROM historial WHERE rol = 1";
        $mostrar = $this->db->query($sql);
        return $mostrar;
    }

    public function sumaIngresos()
    {
        $sql = "SELECT SUM(income_veronica + income_pablo + income_extra) as ingresosTotales, saving_verpa as ahorros from register r WHERE r.id = {$this->getIdRegistro()}";
        $sumaGastos = $this->db->query($sql);
        $obtener = $sumaGastos->fetch_object();
        return $obtener;
    }

    public function deudasGlobales()
    {
        $sql = "SELECT SUM(c.Gastos) as deudasGlobales FROM register r INNER JOIN historial c ON r.id = c.idRegister WHERE c.idRegister = {$this->getIdRegistro()} AND rol = 0";
        $deudasGlobales = $this->db->query($sql);
        $obtener = $deudasGlobales->fetch_object();
        return $obtener->deudasGlobales;
    }

    public function gastosCarrefour()
    {
        $sql = "SELECT SUM(c.Gastos) as gastosCarrefour FROM historial c where (c.idRegister = {$this->getIdRegistro()} AND rol = 0) and c.nombre= 'Carrefour'";
        $gastosCarrefour = $this->db->query($sql);
        $obtener = $gastosCarrefour->fetch_object();
        return $obtener->gastosCarrefour;
    }

    public function gastosServicios()
    {
        $sql = "SELECT SUM(c.Gastos) as gastosServicios FROM historial c where (c.idRegister = {$this->getIdRegistro()} AND rol = 0) and c.nombre= 'Servicios'";
        $gastosServicios = $this->db->query($sql);
        $obtener = $gastosServicios->fetch_object();
        return $obtener->gastosServicios;
    }

    public function gastosDeudas()
    {
        $sql = "SELECT SUM(c.Gastos) as gastosDeudas FROM historial c where (c.idRegister = {$this->getIdRegistro()} AND rol = 0) and c.nombre= 'Deudas'";
        $gastosDeudas = $this->db->query($sql);
        $obtener = $gastosDeudas->fetch_object();
        return $obtener->gastosDeudas;
    }

    public function gastosPendiente()
    {
        $sql = "SELECT SUM(c.Gastos) as gastosPendiente FROM historial c where (c.idRegister = {$this->getIdRegistro()} AND status = 'PENDIENTE')";
        $gastosPendiente = $this->db->query($sql);
        $obtener = $gastosPendiente->fetch_object();
        return $obtener->gastosPendiente;
    }

}

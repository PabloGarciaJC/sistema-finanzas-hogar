<?php
class Configuracion
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
        $sql = "INSERT INTO configuracion (nombre,descripcion,gastos,fechaCorte,status,rol) VALUES ('{$this->nombre}','{$this->descripcion}', {$this->gastos}, '{$this->fechaCorte}', '{$this->status}', 1)";
        $save = $this->db->query($sql);
        if ($save) {
            echo 1;
        }
    }

    public function mostrar()
    {
        $sql = "SELECT * FROM configuracion WHERE rol = 1";
        $mostrar = $this->db->query($sql);
        return $mostrar;
    }

    public function repoblar()
    {
        $sql = "INSERT INTO historial (nombre, descripcion, gastos, fechaCorte, status, rol) ";
        $sql .= "SELECT nombre, descripcion, gastos, fechaCorte, status, rol ";
        $sql .= "FROM configuracion ";
        $repoblar = $this->db->query($sql);
        $repoblar;
    }

    public function listar($ultimoRegistro, $mostrarRegistros)
    {
        $sql = "SELECT * FROM configuracion c ";

        if ($this->getBuscador() == '') {
            $sql .= "WHERE rol = 1 ORDER BY FIELD (nombre,'Carrefour','Servicios','Deudas') ASC ";
        } else {

            $sql .= "WHERE (c.nombre LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.descripcion LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.gastos LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.fechaCorte LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.status LIKE '%{$this->getBuscador()}%') ";
            $sql .= "ORDER BY c.id DESC ";
        }

        $sql .= "LIMIT $ultimoRegistro, $mostrarRegistros;";
        $listar = $this->db->query($sql);
        return $listar;
    }

    public function conteoRegistros()
    {
        $sql = "SELECT count(c.id) as 'registrosTotales' FROM configuracion c ";

        if ($this->getBuscador() == '') {
            $sql .= "WHERE (rol = 1) ORDER BY FIELD (nombre,'Carrefour','Servicios','Deudas') ASC ";
        } else {

            $sql .= "WHERE (c.nombre LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.descripcion LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.gastos LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.fechaCorte LIKE '%{$this->getBuscador()}%' OR ";
            $sql .= "c.status LIKE '%{$this->getBuscador()}%') ";
            $sql .= "ORDER BY c.id DESC ";
        }

        $listar = $this->db->query($sql);
        $obtener = $listar->fetch_object();
        $conteo = $obtener->registrosTotales;

        return $conteo;
    }

    public function editar()
    {
        $sql = "UPDATE configuracion SET "
            . "nombre= '{$this->nombre}', "
            . "descripcion= '{$this->descripcion}', "
            . "gastos={$this->gastos}, "
            . "fechaCorte='{$this->fechaCorte}', "
            . "status = '{$this->status}', "
            . "rol = 1 "
            . "WHERE id= {$this->id};";

        $save = $this->db->query($sql);

        if ($save) {
            echo 1;
        }
    }

    public function delete()
    {
        $sql = "SELECT * FROM configuracion WHERE id= {$this->id} AND rol = 1";
        $delete = $this->db->query($sql);

        if ($delete->num_rows > 0) {
            $sql = "DELETE FROM configuracion WHERE id= {$this->id}";
            $delete = $this->db->query($sql);
            if ($delete) {
                echo 1;
            }
        }
    }

    public function sumaDeudas()
    {
        $sql = "SELECT SUM(c.Gastos) as sumaDeudas FROM configuracion c where rol = 1";
        $sumaDeudas = $this->db->query($sql);
        $obtener = $sumaDeudas->fetch_object();
        return $obtener->sumaDeudas;
    }
}

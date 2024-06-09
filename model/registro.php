<?php

class Registro
{
  private $id;
  private $ingresoVeronica;
  private $ingresoPablo;
  private $ingresoExtra;
  private $savingVerpa;
  private $mes;
  private $year;
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

  public function setIngresoVeronica($ingresoVeronica)
  {
    $this->ingresoVeronica = $ingresoVeronica;
  }

  public function setIngresoPablo($ingresoPablo)
  {
    $this->ingresoPablo = $ingresoPablo;
  }

  public function setIngresoExtra($ingresoExtra)
  {
    $this->ingresoExtra = $ingresoExtra;
  }

  public function setSavingVerpa($savingVerpa)
  {
    $this->savingVerpa = $savingVerpa;
  }

  public function setMes($mes)
  {
    $this->mes = $mes;
  }

  public function setYear($year)
  {
    $this->year = $year;
  }

  public function setBuscador($buscador)
  {
    $this->buscador = $buscador;
  }

  // GETTER
  public function getId()
  {
    return $this->id;
  }

  public function getIngresoVeronica()
  {
    return $this->ingresoVeronica;
  }

  public function getIngresoPablo()
  {
    return $this->ingresoPablo;
  }

  public function getIngresoExtra()
  {
    return $this->ingresoExtra;
  }

  public function getSavingVerpa()
  {
    return $this->savingVerpa;
  }

  public function getMes()
  {
    return $this->mes;
  }

  public function getYear()
  {
    return $this->year;
  }

  public function getBuscador()
  {
    return $this->buscador;
  }

  //CODIGO SQL 

  public function guardar()
  {
    $sql = "INSERT INTO register (income_veronica,
                                  income_pablo,
                                  income_extra, 
                                  saving_verpa,
                                  month,
                                  year)";

    $sql .= "VALUES ({$this->ingresoVeronica},
                    {$this->ingresoPablo},
                    {$this->ingresoExtra},
                    {$this->savingVerpa},
                    '{$this->mes}',
                    {$this->year});";

    $save = $this->db->query($sql);

    if ($save) {
      echo 1;
    }
  }

  public function listar($ultimoRegistro, $mostrarRegistros)
  {
    $sql = "SELECT * FROM register r ";

    if ($this->getBuscador() == '') {

      $sql .= "ORDER BY r.id DESC ";
    } else {

      $sql .= "WHERE (r.income_veronica LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.income_pablo LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.income_extra LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.saving_verpa LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.month LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.year LIKE '%{$this->getBuscador()}%')";
      $sql .= "ORDER BY r.id DESC ";
    }

    $sql .= "LIMIT $ultimoRegistro, $mostrarRegistros;";
    
    $listar = $this->db->query($sql);

    return $listar;
  }


  public function edit()
  {
    $sql = "UPDATE register SET "
      . "income_veronica= {$this->ingresoVeronica}, "
      . "income_pablo= {$this->ingresoPablo}, "
      . "income_extra={$this->ingresoExtra}, "
      . "saving_verpa={$this->savingVerpa}, "
      . "month = '{$this->mes}', "
      . "year= {$this->year} "
      .  "WHERE id={$this->id}";

    $save = $this->db->query($sql);

    if ($save) {
      echo 1;
    }
  }

  public function delete()
  {
    $sql = "DELETE FROM register WHERE id= {$this->id}";
    $delete = $this->db->query($sql);

    if ($delete) {
      echo 1;
    }
  }


  public function conteoRegistros()
  {
    $sql = "SELECT count(r.id) as 'registrosTotales' FROM register r ";

    if ($this->getBuscador() == '') {

      $sql .= "ORDER BY r.id DESC;";
    } else {

      $sql .= "WHERE (r.income_veronica LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.income_pablo LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.income_extra LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.saving_verpa LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.month LIKE '%{$this->getBuscador()}%' OR ";
      $sql .= "r.year LIKE '%{$this->getBuscador()}%')";
      $sql .= "ORDER BY r.id DESC;";
    }

    $listar = $this->db->query($sql);
    $obtener = $listar->fetch_object();
    $conteo = $obtener->registrosTotales;

    return $conteo;
  }
}

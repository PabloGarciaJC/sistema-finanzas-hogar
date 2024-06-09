<?php

class Database {

    static public function connect(){
        $db = new mysqli('localhost','pablogarciajcbd','123','pablogarciajc_gestionhogar');   
    
        $db->query("SET NAMES 'utf8'");   
        // echo 'si hay conexion'; 
        return $db;
    }
}
// $tes = new Database();
// $prueba = $tes->connect(); 
// var_dump($prueba); 
 
?>

<?php 
namespace App\Models;

  Class Db{

    public $conexion;

    function __construct(){
      $this-> $conexion = new mySqli("localhost","root","","gamerpulse");

      if($this -> $conexion->connect_errno){
        printError($this -> $conexion);
      }
      
    }


    function printError($conexion){
      
      echo "Fallo al conectar con SQL: " .$conexion -> connect_errno;

    }

  }

?>
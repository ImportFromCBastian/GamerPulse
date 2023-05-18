<?php 

namespace App\Models;
use PDO;

class Db{
  private $hostName = "localhost";
  private $dataBaseName = "gamerpulse";
  private $password = "";
  private $userName = "root";
  private $dataBase;
  

  function __construct(){
    try{

      $conn = new PDO("mysql:host=$this->hostName;dbname=$this->dataBaseName",$this->userName,$this->password);
      $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this-> dataBase = $conn;

    }catch(PDOException $e){

      echo "Error: ".$e->getMessage().".";
      
    }

  }

  function conection(){
    return $this->dataBase;
  }

}

?>
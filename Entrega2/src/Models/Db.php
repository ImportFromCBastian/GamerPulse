<?php

namespace App\Models;
use PDO;

Class Db{

  private $host = "localhost";
  private $dataBaseName = "gamerpulse";
  private $user = "root";
  private $password = "";
  

  function construct(){
    try{

      $conection = new PDO("mysql:host = $this->host;dbname = $this->dataBaseName" , $this->user , $this->password);
      $conection -> setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $error){

      echo "Error: ". $error -> getMessage() ." al conectarse.";

    }
  }

}

?>
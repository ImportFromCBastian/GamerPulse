<?php 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Db as DataBase;
use PDO;

class PlatformController{
  private $dataBaseConnection;
  private $status;

  function __construct(){

    $this->dataBaseConnection = new DataBase();
    $this->dataBaseConnection = $this->dataBaseConnection->conection();

  }

  function getStatus(){
    return $this->status;
  }

  function getAllPlatforms(Request $request, Response &$response){
    try{
      $sqlQuery = "SELECT * FROM plataformas";  

      $query = $this->dataBaseConnection -> query($sqlQuery);

      $platforms = $query -> fetchAll(PDO::FETCH_ASSOC);
      
      $response ->getBody()->write(json_encode($platforms));


      $query = null;
      $this->dataBaseConnection = null;
      
    }catch(PDOException $e){
      
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }


  function postPlatform(Request $request,Response &$response){
    try{
      $valid = json_decode($request->getBody());

      if($valid != null && $valid->nombre != ""){

        $platform = json_decode($request->getBody());
        $sqlQuery = "INSERT INTO plataformas (id,nombre) VALUES (NULL,'$platform->nombre')";  
      

        $query = $this->dataBaseConnection -> query($sqlQuery);

        
        $query = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"Plataforma insertada con exito!."]));
      }else{

        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $this->status = 400;
      }
    }catch(PDOException $e){
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }

  function putPlatform(Request $request,Response &$response,$args){
    try{

      $id = $args['id'];
      $platformName = json_decode($request->getBody());
      
      $sqlQueryID = "SELECT * FROM plataformas WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQueryID);
      $valid = $query->fetch(PDO::FETCH_ASSOC);


      
      if(!empty($valid) && !empty($platformName) && !empty($platformName->nombre)){
        
        $sqlQueryUpdate = "UPDATE plataformas SET nombre = '$platformName->nombre' WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Plataforma actualizado con exito!."]));
      }else{
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $this->status = 400;
      }
      
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query = null;

      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }

  function deletePlatform(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM plataformas WHERE id = $id";
      $sqlQueryPlatformAssoc = "SELECT * FROM juegos WHERE id_plataforma = $id";
      
      $validID = $this->dataBaseConnection->query($sqlQueryID)->fetch(PDO::FETCH_ASSOC);
      $validPlatform = $this->dataBaseConnection->query($sqlQueryPlatformAssoc)->fetch(PDO::FETCH_ASSOC);

      if(!empty($validID) && !empty($validPlatform) || empty($validID)){
        
        $validID = null;
        $validPlatform = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $this->status = 400;
      }else{

        $sqlQueryUpdate = "DELETE FROM plataformas WHERE id = $id";  
        
        $query = $this->dataBaseConnection-> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Plataforma borrada con exito!."]));
      }

    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query = null;

      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }
}

?>
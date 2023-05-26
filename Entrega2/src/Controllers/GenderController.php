<?php 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Db as DataBase;
use PDO;

class GenderController{
  private $dataBaseConnection;
  private $status = 200;

  function __construct(){
    $this->dataBaseConnection = new DataBase();
    $this->dataBaseConnection = $this->dataBaseConnection->conection();
  }

  function getStatus(){
    return $this->status;
  }

  function getAllGenders(Request $request, Response &$response){
    try{
      $sqlQuery = "SELECT * FROM generos";  

      $query = $this->dataBaseConnection -> query($sqlQuery);

      $generos = $query -> fetchAll(PDO::FETCH_ASSOC);
      
      $response ->getBody()->write(json_encode($generos));


      $query = null;
      $this->dataBaseConnection = null;
      
      $response->withHeader("Content-Type","application/json")->withStatus(200);

    }catch(PDOException $e){
      
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $response->withHeader("content-type","application/json")->withStatus(404);
    }
  }


  function postGender(Request $request,Response &$response){
    try{
      $valid = json_decode($request->getBody());

      if($valid != null && $valid->nombre != ""){
        $genero = json_decode($request->getBody());
        $sqlQuery = "INSERT INTO generos (id,nombre) VALUES (NULL,'$genero->nombre')";  
      

        $query = $this->dataBaseConnection -> query($sqlQuery);

        $response->getBody()->write(json_encode(['mensaje'=>"Genero insertado con exito!."]));

        $query = null;
        $this->dataBaseConnection = null;

        $response->withHeader("Content-Type","application/json")->withStatus(200);
      }else{

        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $response->withHeader("content-type","application/json")->withStatus(400);
      }
    }catch(PDOException $e){
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $response->withHeader("content-type","application/json")->withStatus(404);
    }
  }

  function putGender(Request $request,Response &$response,$args){
    try{

      $id = $args['id'];
      $genderName = json_decode($request->getBody());
      
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQueryID);
      $valid = $query->fetch(PDO::FETCH_ASSOC);


      if(!empty($valid) && !empty($genderName) && !empty($genderName->nombre)){
        
        $sqlQueryUpdate = "UPDATE generos SET nombre = '$genderName->nombre' WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Genero actualizado con exito!."]));
        $response->withHeader("Content-Type","application/json")->withStatus(200);
      }else{
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $response->withHeader("Content-Type","application/json")->withStatus(400);
        
        
      }
      
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query = null;

      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $response->withHeader("content-type","application/json")->withStatus(404);
    }
  }

  function deleteGame(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $validID = $this->dataBaseConnection->query($sqlQueryID)->fetch(PDO::FETCH_ASSOC);

      echo"hola";
      die;

      if(empty($validID)){
        
        $validID = null;
        $validGender = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $response->withHeader("Content-Type","application/json")->withStatus(400);
      }else{
      
        $sqlQueryUpdate = "DELETE FROM juegos WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Juego borrado con exito!."]));
        $response->withHeader("Content-Type","application/json")->withStatus(200);
        
        
      }
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $response->withHeader("content-type","application/json")->withStatus(404);
    }
  }
}

?>
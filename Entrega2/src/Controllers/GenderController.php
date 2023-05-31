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

  function getGenders(Request $request, Response &$response){
    try{
      $sqlQuery = "SELECT * FROM generos";  

      $query = $this->dataBaseConnection -> query($sqlQuery);

      $generos = $query -> fetchAll(PDO::FETCH_ASSOC);
      
      $response ->getBody()->write(json_encode($generos));


      $query = null;
      $this->dataBaseConnection = null;
      

    }catch(PDOException $e){
      
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }


  function postGender(Request $request,Response $response){
    try{
      $valid = json_decode($request->getBody());

      if(!empty($valid) && !empty($valid->nombre)){
        $genero = json_decode($request->getBody());
        $sqlQuery = "INSERT INTO generos (id,nombre) VALUES (NULL,'$genero->nombre')";  
      

        $query = $this->dataBaseConnection -> query($sqlQuery);

        $response->getBody()->write(json_encode(['mensaje'=>"Genero insertado con exito!."]));

        $query = null;
        $this->dataBaseConnection = null;

      }else{

        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR IN PARAMETERS => BAD REQUEST."]));
        $this->status = 400;
      }
    }catch(PDOException $e){
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }

  function putGender(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQueryID);
      $valid = $query->fetch(PDO::FETCH_ASSOC);

      if(empty($valid)){
        $query = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR FOUNDING SOURCE => NOT FOUND."]));
        $this->status = 404;
      }else{
        $genderName = json_decode($request->getBody());

        if(empty($genderName) || empty($genderName->nombre)){ 
          $response->getBody()->write(json_encode(['mensaje'=>"ERR IN (EMPTY) PARAMETERS => BAD REQUEST."]));
          $this->status = 400;
          return;

        }
        
        $sqlQueryUpdate = "UPDATE generos SET nombre = '$genderName->nombre' WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;
  
        $response->getBody()->write(json_encode(['mensaje'=>"Genero actualizado con exito!."]));
        
        
      }
      
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query = null;

      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }

  function deleteGender(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $validID = $this->dataBaseConnection->query($sqlQueryID)->fetch(PDO::FETCH_ASSOC);
      
      if(empty($validID)){
        
        $validID = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR FOUNDING SOURCE => NOT FOUND."]));
        $this->status = 404;
        
      }else{
        $sqlQueryGenderAssoc = "SELECT * FROM juegos WHERE id_genero = $id";
        $validGender = $this->dataBaseConnection->query($sqlQueryGenderAssoc)->fetch(PDO::FETCH_ASSOC);

        if(!empty($validGender)){
          $validID = null;
          $validGender = null;
          $this->dataBaseConnection = null;
          
          $response->getBody()->write(json_encode(['mensaje'=>"ERR GENDER ASSOC TO GAME => BAD REQUEST."]));
          $this->status = 400;

          return;

        }
        $sqlQueryUpdate = "DELETE FROM generos WHERE id = $id";  
        
        $query = $this->dataBaseConnection-> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Juego borrado con exito!."]));
        
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
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
      

    }catch(PDOException $e){
      
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
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

  function deleteGender(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      $sqlQueryGenderAssoc = "SELECT * FROM juegos WHERE id_genero = $id";
      
      $validID = $this->dataBaseConnection->query($sqlQueryID)->fetch(PDO::FETCH_ASSOC);
      $validGender = $this->dataBaseConnection->query($sqlQueryGenderAssoc)->fetch(PDO::FETCH_ASSOC);

      if(!empty($validID) && !empty($validGender) || empty($validID)){
        
        $validID = null;
        $validGender = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        $this->status = 400;
      }else{
      
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
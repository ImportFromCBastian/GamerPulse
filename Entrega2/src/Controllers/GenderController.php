<?php 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Db as DataBase;
use PDO;

class GenderController{
  private $dataBaseConnection;

  function __construct(){
    $this->dataBaseConnection = new DataBase();
    $this->dataBaseConnection = $this->dataBaseConnection->conection();
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
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));

      $query = null;
      $this->dataBaseConnection = null;
      
      //Caso de ser una mala consulta devuelve 400 BAD REQUEST
      $response->withHeader("content-type","application/json")->withStatus(400);
    }
  }


  function postGender(Request $request,Response &$response){
    try{
      $valid = json_decode($request->getBody());

      if($valid != NULL){
        $genero = json_decode($request->getBody());
        $sqlQuery = "INSERT INTO generos (id,nombre) VALUES (NULL,'$genero->nombre')";  
      

        $query = $this->dataBaseConnection -> query($sqlQuery);

        $response->getBody()->write(json_encode(['mensaje'=>"Genero insertado con exito!."]));

        $query = null;
        $this->dataBaseConnection = null;

        return $response->withHeader("Content-Type","application/json")->withStatus(200);
      }else{

        $response->getBody()->write(json_encode(['mensaje'=>"No entro parametros."]));
        $this->dataBaseConnection = null;
        return $response->withHeader("content-type","application/json")->withStatus(400);
      }
    }catch(PDOException $e){
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $query = null;
      $this->dataBaseConnection = null;
      
      //Caso de ser una mala consulta devuelve 400 BAD REQUEST
      return $response->withHeader("content-type","application/json")->withStatus(404);
    }
  }

  function putGender(Request $request,Response &$response,$args){
    try{

      $id = $args['id'];
      $genderName = json_decode($request->getBody());
      
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQueryID);
      $valid = $query->fetch(PDO::FETCH_ASSOC);


      if(!$valid || $genderName->nombre != "" || !empty($genderName)){
        
        $sqlQueryUpdate = "UPDATE generos SET nombre = '$genderName->nombre' WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $response->getBody()->write(json_encode(['mensaje'=>"Genero actualizado con exito!."]));
        $query = null;
        $this->dataBaseConnection = null;
        return $response->withHeader("Content-Type","application/json")->withStatus(200);
      }else{
        
        $response->getBody()->write(json_encode(['mensaje'=>"ID inexistente o campo 'nombre' vacio."]));
        $query = null;
        $this->dataBaseConnection = null;
        return $response->withHeader("Content-Type","application/json")->withStatus(404);
        
        
      }
      
    }catch(PDOException $e){
      //Caso de ser una mala consulta devuelve 400 BAD REQUEST
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->dataBaseConnection = null;
      $query = null;
      return $response->withHeader("content-type","application/json")->withStatus(400);
    }
  }

  function deleteGender(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM generos WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQueryID);
      $valid = $query->fetch(PDO::FETCH_ASSOC);

      if(!$valid){
        
        $query = null;
        $valid = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ID inexistente."]));
        return $response->withHeader("Content-Type","application/json")->withStatus(404);
      }else{

        $sqlQueryUpdate = "DELETE FROM generos WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
        $query = null;
        $this->dataBaseConnection = null;

        $response->getBody()->write(json_encode(['mensaje'=>"Genero borrado con exito!."]));
        return $response->withHeader("Content-Type","application/json")->withStatus(200);
        
        
      }
    }catch(PDOException $e){
      //Caso de ser una mala consulta devuelve 400 BAD REQUEST
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->dataBaseConnection = null;
      $query = null;
      return $response->withHeader("content-type","application/json")->withStatus(400);
    }
  }


}
  



?>
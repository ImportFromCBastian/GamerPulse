<?php 
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Db as DataBase;
use PDO;

class GameController{
  private $dataBaseConnection;
  private $status = 200;

  function __construct(){

    $this->dataBaseConnection = new DataBase();
    $this->dataBaseConnection = $this->dataBaseConnection->conection();

  }

  function getStatus(){
    return $this->status;
  }

  function getAllGames(Request $request, Response &$response){
    try{
      $sqlQuery = "SELECT * FROM juegos";  

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

  function deleteGame(Request $request,Response &$response,$args){
    try{
      $id = $args['id'];
      $sqlQueryID = "SELECT * FROM juegos WHERE id = $id";
      
      $validID = $this->dataBaseConnection->query($sqlQueryID)->fetch(PDO::FETCH_ASSOC);

      if(empty($validID)){
        
        $validID = null;
        $this->dataBaseConnection = null;
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
        
        $this->status = 400;
      }else{

        $sqlQueryUpdate = "DELETE FROM juegos WHERE id = $id";  
        
        $query = $this->dataBaseConnection -> query($sqlQueryUpdate);     
        
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
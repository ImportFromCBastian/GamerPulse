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

  function putGame (Request $request, Response $response, $args){
    try{
      $id = $args['id'];
      $gameName = json_encode($request->getBody());
      
      $sqlQuery = "SELECT * FROM juegos WHERE id = $id";

      $query = $this->dataBaseConnection->query($sqlQuery);
      $valid = $query->fetch(PDO::FETCH_ASSOC);

      if (!empty($valid) && !empty($gameName) && !empty($gameName->nombre)){

        $sqlQueryUpdate = "UPDATE generos SET nombre = '$genderName->nombre' WHERE id=$id";

        $query=$this->dataBaseConnection->query($sqlQueryUpdate);

        $query=null;
        $this->dataBaseConnection=null;

        $response->getBody()->write(json_encode(['mensaje'=>"Juego actualizado con exito!"]));
      }else{
        $query=null;
        $this->dataBaseConnection=null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERROR"]));
        $this->status=400;

      }
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query=null;

      $response->getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status=404;
    }
  }

    function postGame (Request $request, Response $response,$args){
      try{

        $game= json_decode($request->getBody());
        
        if(!empty($game)){
          $errorMessage = '';
          
          if (empty($game->nombre)) {
            $errorMessage .= 'El nombre del juego no puede estar vacío. ';
          }

          if (!strpos($game->imagen, '/image')) {
            $errorMessage .= 'La imagen del juego debe contener "/image". ';
          }

          if (strlen($game->url) > 80) {
            $errorMessage .= 'La URL del juego no puede tener más de 80 caracteres. ';
          }

          if (strlen($game->descripcion) > 255) {
            $errorMessage .= 'La descripción del juego no puede tener más de 255 caracteres. ';
          }

          if (!empty($errorMessage)) {
            $response->getBody()->write(json_encode(['mensaje' => $errorMessage]));
            $this->status = 400;
            return;
          }

          $sqlQuery = "INSERT INTO juegos(id,nombre,imagen, descripcion, plataforma,URL,genero) VALUES (NULL,'$game->nombre','$game->imagen','$game->descripcion','$game->plataforma','$game->url','$game->genero')";

          $query = $this->dataBaseConecction->query($sqlQuery);

          $response->getBody()->write(json_encode(['mensaje'=>'Juego agregado con exito!']));
          
          $this->status=200;

          $query = null;
          $this->dataBaseConnection = null;

        }else{

          $response->getBody()->write(json_encode(['mensaje'=>"ERR BAD REQUEST."]));
          $this->status = 400;
          $this->dataBaseConnection = null;

        }

      }catch(PDOException $e){

        $query = null;
        $this->dataBaseConnection = null;
        $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
        $this->status = 404;

      }
    }





}
?>
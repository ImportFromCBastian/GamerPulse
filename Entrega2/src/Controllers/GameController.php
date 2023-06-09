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

  function getGames(Request $request, Response &$response){
    try{
     /*join plataformas p on j.id_plataforma=p.id join generos g on j.id_genero=g.id*/
     $sqlQuery = "SELECT j.*, p.nombre AS nombre_plataforma, g.nombre AS nombre_genero 
     FROM juegos j 
     JOIN plataformas p ON j.id_plataforma = p.id 
     JOIN generos g ON j.id_genero = g.id 
     WHERE 1 = 1";


      if(!empty($request->getQueryParams())){
        $params = $request->getQueryParams();

        $nombre = !empty($params['nombre']) ? $params['nombre'] : "" ;
        $id_plataforma = !empty($params['plataforma']) ? $params['plataforma'] : "";
        $id_genero = !empty($params['genero']) ? $params['genero'] : "";
        $orden = !empty($params['orden']) ? $params['orden'] : "";


        if(!empty($nombre)){
          $sqlQuery.=" AND j.nombre LIKE '%$nombre%'";    
        }

        if(!empty($id_genero)){
          $sqlQuery.=" AND j.id_genero = $id_genero";
        }
        
        if(!empty($id_plataforma)){
          $sqlQuery.=" AND j.id_plataforma = $id_plataforma";
        }

        if(!empty($orden)){
          if(strpos($orden,"ASC") !== false)
            $sqlQuery .= " ORDER BY nombre ASC";
            
          if(strpos($orden,"DESC") !== false)
            $sqlQuery .= " ORDER BY nombre DESC";
            
          

        }
      }
      
      $query = $this->dataBaseConnection -> query($sqlQuery);

      $games = $query -> fetchAll(PDO::FETCH_ASSOC);
      
      if(empty($games)){
        $response-> getBody()->write(json_encode(['mensaje'=>'FETCHING DOESNT MATCH => EMPTY RESOURCE']));
        $query = null;
        $this->dataBaseConnection = null;
        return;
        
      } 
      $query = null;
      $this->dataBaseConnection = null;
      
      $response ->getBody()->write(json_encode($games));

    }catch(PDOException $e){
      
      $query = null;
      $this->dataBaseConnection = null;
      
      $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status = 404;
    }
  }

  function fetchGame(Request $request, Response &$response, $args){
    try{
      $id = $args['id'];
      $sqlQuery = "SELECT * FROM juegos WHERE id = $id";  

      $query = $this->dataBaseConnection -> query($sqlQuery);

      $games = $query -> fetch(PDO::FETCH_ASSOC);
      if(!$games){
        $response ->getBody()->write(json_encode(['mensaje'=> "NO EXISTE JUEGO CON ESE ID"]));
        $query = null;
        $this->dataBaseConnection = null;
        return;
      } 
      $query = null;
      $this->dataBaseConnection = null;
      
      $response ->getBody()->write(json_encode($games));

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
        
        $response->getBody()->write(json_encode(['mensaje'=>"ERR NOT FOUND."]));
        $this->status = 404;
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

      $sqlQuery = "SELECT * FROM juegos WHERE id = $id";
      
      $query = $this->dataBaseConnection->query($sqlQuery);
      $valid = $query->fetch(PDO::FETCH_ASSOC);
      
      if (!empty($valid)){
        $game = json_decode($request->getBody());
        $errorMessage="";
        if(!empty($game)){
          if (empty($game->nombre)) {
              $errorMessage .= 'No se recibió nombre.  ';
            }else{
              if ($game->nombre ===''){
                $errorMessage .="El nombre recibido está vacío. ";
              }
            }
            
            if (empty($game->imagen)) {
              $errorMessage .= 'No se recibio imagen. ';
            }else{
              if(strpos($game->tipo_imagen,"image/") === false){
                $errorMessage.= "El documento seleccionado no es imagen o esta vacia.";

              }else{ 
                $decodedData = base64_decode($game->imagen, true);
                //se verifica si la decodificacion fue exitosa  y si se pudo construir una imagen a partir de estos datos
                if ($decodedData !== true) {
                  $errorMessage .= "La imagen no está codificada en Base64.";
                  } 
              }
            }
            

            if (strlen($game->url)>80){
              $errorMessage.="La URL es demasiado larga. ";
            }
          
            if (strlen($game->descripcion)>255){
              $errorMessage .="La descripcion es demasiado larga. ";
            }
          
            if (empty($game->id_genero)) {
              $errorMessage .= 'No se recibió genero. ';
            }

            if (empty($game->id_plataforma)) {
              $errorMessage .= 'No se recibió plataforma. ';
            }
        }else{
          $errorMessage .= 'No se recibió juego. ';
        }
        if (!empty($errorMessage)) {
            $response->getBody()->write(json_encode(['mensaje' => $errorMessage.""]));
            $this->status = 400;
            $query = null;
            $this->dataBaseConnection = null;

            return;
        }
        $sqlQueryUpdate = "UPDATE juegos SET nombre = '$game->nombre', descripcion = '$game->descripcion' , url = '$game->url' , imagen = '$game->imagen' , id_plataforma = '$game->id_plataforma' , id_genero = '$game->id_genero' , tipo_imagen = '$game->tipo_imagen' WHERE id = $id";

        $query=$this->dataBaseConnection->query($sqlQueryUpdate);

        $query=null;
        $this->dataBaseConnection=null;

        $response->getBody()->write(json_encode(['mensaje'=>"Juego actualizado con exito!"]));
      }else{
        $query=null;
        $this->dataBaseConnection=null;

        $response->getBody()->write(json_encode(['mensaje'=>"ERR FOUNDING SOURCE"]));
        $this->status=404;

      }
    }catch(PDOException $e){
      $this->dataBaseConnection = null;
      $query=null;

      $response->getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
      $this->status=404;
    }
  }

    function postGame (Request $request, Response $response){
      try{
        $game= json_decode($request->getBody());
        if(!empty($game)){
          $errorMessage = '';

          if (empty($game->nombre)) {
            $errorMessage .= 'No se recibió nombre.  ';
          }else{
            if ($game->nombre === ''){
              $errorMessage .="El nombre recibido está vacío. ";
            }
          }
          
          if (empty($game->imagen)) {
            $errorMessage .= 'No se recibio imagen. ';
          }else{
            if(strpos($game->tipo_imagen,"image/") === false){
              $errorMessage.= "El documento seleccionado no es imagen.";
            }else{  
              $decodedData = base64_decode($game->imagen, true);
              //se verifica si la decodificacion fue exitosa  y si se pudo construir una imagen a partir de estos datos
              if (!$decodedData) {
                $errorMessage .= "La imagen no está codificada en Base64.";
                } 
            }
          }

    
          if (strlen($game->url)>80){
            $errorMessage.="La URL es demasiado larga. ";
          }

      
          if (strlen($game->descripcion)>255){
            $errorMessage.="La descripcion es demasiado larga. ";
          }
          

          if (empty($game->id_genero)) {
            $errorMessage .= 'No se recibió genero. ';
          }

          if (empty($game->id_plataforma)) {
            $errorMessage .= 'No se recibió plataforma. ';
          }

          if (!empty($errorMessage)) {
            $response->getBody()->write(json_encode(['mensaje' => $errorMessage]));
            $this->status = 400;
            $query = null;
            $this->dataBaseConnection = null;
            return;
          }

          $sqlQuery = "INSERT INTO juegos(id,nombre,imagen,tipo_imagen, descripcion, url,id_genero,id_plataforma) VALUES (NULL,'$game->nombre','$game->imagen','$game->tipo_imagen','$game->descripcion','$game->url','$game->id_genero','$game->id_plataforma')";

          $query = $this->dataBaseConnection->query($sqlQuery);

          $response->getBody()->write(json_encode(['mensaje'=>'Juego agregado con exito!']));

          $query = null;
          $this->dataBaseConnection = null;

        }else{
          $response->getBody()->write(json_encode(['mensaje'=>"ERROR (EMPTY) PARAMETERS"]));
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
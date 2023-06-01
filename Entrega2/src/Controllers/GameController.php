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
      $sqlQuery = "SELECT * FROM juegos";  

      if(!empty($request->getBody())){
        $fetcher = json_decode($request->getBody());
        
        if(!empty($fetcher->nombre) && empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%'";

        }else if(empty($fetcher->nombre) && !empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE id_genero = '$fetcher->idGenero'";

        }else if(empty($fetcher->nombre) && empty($fetcher->idGenero) && !empty($fetcher->idPlataforma) && empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE id_plataforma = '$fetcher->idPlataforma'";
          
        }else if(empty($fetcher->nombre) && empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && !empty($fetcher->orden)){
          if(strpos($fetcher->orden,"ASC") !== false){
            $sqlQuery = $sqlQuery." ORDER BY nombre ASC";
            
          }else if(strpos($fetcher->orden,"DESC") !== false){
            $sqlQuery = $sqlQuery." ORDER BY nombre DESC";
            
          }
        }else if(!empty($fetcher->nombre) && !empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%' AND id_genero = '$fetcher->idGenero'";
          
        }else if(!empty($fetcher->nombre) && empty($fetcher->idGenero) && !empty($fetcher->idPlataforma) && empty($fetcher->orden)){
            $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%' AND id_plataforma = '$fetcher->idPlataforma'";
            
        }else if(!empty($fetcher->nombre) && empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && !empty($fetcher->orden)){
          if(strpos($fetcher->orden,"ASC") !== false){
            $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%' ORDER BY nombre ASC ";
            
          }else if(strpos($fetcher->orden,"DESC") !== false){
            $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%' ORDER BY nombre DESC ";
            
          }
          
        }else if(empty($fetcher->nombre) && !empty($fetcher->idGenero) && !empty($fetcher->idPlataforma) && empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE id_genero = '$fetcher->idGenero' AND id_plataforma = '$fetcher->idPlataforma'";
          
        }else if (empty($fetcher->nombre) && !empty($fetcher->idGenero) && empty($fetcher->idPlataforma) && !empty($fetcher->orden)){
          if(strpos($fetcher->orden,"ASC") !== false){
            $sqlQuery = $sqlQuery." WHERE id_genero = '$fetcher->idGenero' ORDER BY nombre ASC";  
            
          }else if(strpos($fetcher->orden,"DESC") !== false){
            $sqlQuery = $sqlQuery." WHERE id_genero = '$fetcher->idGenero' ORDER BY nombre DESC";
            
          }

        }else if(empty($fetcher->nombre) && empty($fetcher->idGenero) && !empty($fetcher->idPlataforma) && !empty($fetcher->orden)){
           if(strpos($fetcher->orden,"ASC") !== false){
            $sqlQuery = $sqlQuery." WHERE id_plataforma = '$fetcher->idPlataforma' ORDER BY nombre ASC";  
            
          }else if(strpos($fetcher->orden,"DESC") !== false){
            $sqlQuery = $sqlQuery." WHERE id_plataforma = '$fetcher->idPlataforma' ORDER BY nombre DESC";
            
          }

        }else if(!empty($fetcher->nombre) && !empty($fetcher->idGenero) && !empty($fetcher->idPlataforma) && !empty($fetcher->orden)){
          $sqlQuery = $sqlQuery." WHERE nombre LIKE '%$fetcher->nombre%' AND id_genero = '$fetcher->idGenero' AND id_plataforma = '$fetcher->idPlataforma' ORDER BY nombre";
          if(strpos($fetcher->orden,"ASC") !== false){
            $sqlQuery = $sqlQuery." ASC";  
            
          }else if(strpos($fetcher->orden,"DESC") !== false){
            $sqlQuery = $sqlQuery." DESC";
            
          }

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
            $response->getBody()->write(json_encode(['mensaje' => $errorMessage." => BAD REQUEST"]));
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

        $response->getBody()->write(json_encode(['mensaje'=>"ERR FOUNDING SOURCE => NOT FOUND."]));
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
              $alerta.= "El documento seleccionado no es imagen.";
            }else{  
              $decodedData = base64_decode($game->imagen, true);
              //se verifica si la decodificacion fue exitosa  y si se pudo construir una imagen a partir de estos datos
              if ($decodedData !== true) {
                $alerta .= "La imagen no está codificada en Base64.";
                } 
            }
          }

    
          if (strlen($game->url)>80){
            $alerta.="La URL es demasiado larga. ";
          }

      
          if (strlen($game->descripcion)>255){
            $alerta.="La descripcion es demasiado larga. ";
          }
          

          if (empty($game->id_genero)) {
            $errorMessage .= 'No se recibió genero. ';
          }

          if (empty($game->id_plataforma)) {
            $errorMessage .= 'No se recibió plataforma. ';
          }

          if (!empty($errorMessage)) {
            $errorMessage.="=> BAD REQUEST.";
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
          $response->getBody()->write(json_encode(['mensaje'=>"ERROR (EMPTY) PARAMETERS => BAD REQUEST."]));
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
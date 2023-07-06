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
/*
Para aplicar la técnica de consulta preparada y evitar la inyección SQL en la función getGames, puedes modificarla de la siguiente manera:

php
Copy code
function getGames(Request $request, Response &$response){
  try{
    $sqlQuery = "SELECT * FROM juegos WHERE 1 = 1";  
    $params = [];

    if(!empty($request->getBody())){
      $fetcher = json_decode($request->getBody());

      if(!empty($fetcher->nombre)){
        $sqlQuery .= " AND nombre LIKE :nombre";
        $params[':nombre'] = "%" . $fetcher->nombre . "%";
      }

      if(!empty($fetcher->id_genero)){
        $sqlQuery .= " AND id_genero = :id_genero";
        $params[':id_genero'] = $fetcher->id_genero;
      }

      if(!empty($fetcher->id_plataforma)){
        $sqlQuery .= " AND id_plataforma = :id_plataforma";
        $params[':id_plataforma'] = $fetcher->id_plataforma;
      }

      if(!empty($fetcher->orden)){
        if(strpos($fetcher->orden, "ASC") !== false){
          $sqlQuery .= " ORDER BY nombre ASC";
        } else if(strpos($fetcher->orden, "DESC") !== false){
          $sqlQuery .= " ORDER BY nombre DESC";
        }
      }
    }
      
    $query = $this->dataBaseConnection->prepare($sqlQuery);
    $query->execute($params);

    $games = $query->fetchAll(PDO::FETCH_ASSOC);

    if(empty($games)){
      $response->getBody()->write(json_encode(['mensaje' => 'FETCHING DOESNT MATCH => EMPTY RESOURCE']));
    } else {
      $response->getBody()->write(json_encode($games));
    }

    $query = null;
    $this->dataBaseConnection = null;
  } catch(PDOException $e){
    $query = null;
    $this->dataBaseConnection = null;

    $response->getBody()->write(json_encode(['mensaje' => $e->getMessage()]));
    $this->status = 404;
  }
}
En este código, se han realizado los siguientes cambios:

Se ha creado un arreglo $params para almacenar los parámetros de consulta que se utilizarán en la consulta preparada.
En lugar de concatenar directamente los valores en la cadena de consulta, se han reemplazado por marcadores de posición :nombre, :id_genero, :id_plataforma, etc.
Se ha utilizado $params para asociar los valores de los parámetros a los marcadores de posición correspondientes.
Se ha reemplazado la línea $query = $this->dataBaseConnection->query($sqlQuery); por $query = $this->dataBaseConnection->prepare($sqlQuery); para preparar la consulta.
En lugar de llamar a fetchAll directamente en $query, se ha llamado a execute($params) para ejecutar la consulta preparada con los parámetros.
Se ha ajustado el manejo de la respuesta en caso de que no se encuentren juegos, escribiendo un mensaje en el cuerpo de la respuesta.
Se han agregado las líneas $query = null; y $this->dataBaseConnection = null; para liberar los recursos adecuadamente.
Con estos cambios, deberías poder ejecutar la consulta de forma segura y evitar el error de inyección SQL.
*/

  function fetchGame(Request $request, Response &$response, $args){
    try{
      $id = $args['id'];
      $sqlQuery = "SELECT * FROM juegos WHERE id = $id";  

      $query = $this->dataBaseConnection -> query($sqlQuery);

      $games = $query -> fetch(PDO::FETCH_ASSOC);
      if(!$games){
        $response ->getBody()->write(json_encode(['mensaje'=> "no existe un juego con ese id"]));
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
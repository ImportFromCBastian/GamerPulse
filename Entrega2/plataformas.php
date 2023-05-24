<?php 
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  use App\Models\Db as DataBase;

  require __DIR__ . '/vendor/autoload.php';
  
  
  $app = AppFactory::create();

    //Obtener todas las plataformas
    $app -> get('/Entrega2/plataformas.php', function(Request $request, Response $response){

        try{
            $sqlQuery="SELECT * FROM plataformas";

            $db=new DataBase();

            $conexion=$db->conection();

            $query= $conexion-> query($sqlQuery);

            $plataformas = $query->fetchAll(PDO::FETCH_ASSOC);

            $response ->getBody()->write(json_encode($plataformas));

            $query=null;
            $conexion=null;
            
        } catch (PDOException $e){
            $response -> getBody() -> write(json_encode(['mensaje'=> $e->getMessage()]));
            $query=null;
            $conexion=null;

            //Devolver BadRequest en caso de error
            return $response->withHeader("Content-Type","application/json")-> withStatus(400);

        }

    });
    //Crear plataforma
    $app->post('/Entrega2/plataformas.php',function (Request $request, Response $response){
        try{
            $db = new DataBase();
            $conexion=$db->conection();
            $plataforma=json_decode($request->getBody());

            if ($plataforma != NULL){
                $sqlQuery="INSERT INTO plataformas (id,nombre) VALUES (null,'$plataforma->nombre')";

                $query=$conexion->query($sqlQuery);

                $response->getBody()->write(json_encode(['mensaje'=>"Plataforma insertado con exito!"]));

                $query=null;
                $conexion=null;

                return $response ->withHeader("Content-Type","application/json")->withStatus(200);
            }else{
                $response->getBody()->write(json_encode(['mensaje'=> "No entro parametros"]));
                $conexion=null;
                return $response->withHeader("Content-Type","application/json")->withStatus(400);
            }
        
        }catch(PDOException $e){
            $response->getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
            $query=null;
            $conexion=null;

            return $response->withHeader("Content-Type", "application/json")->withStatus(404);
        }

    });
    //Actualizar Plataforma
    $app->put('/Entrega2/plataformas.php{id}', function (Request $request, Response $response,$args) {
        try{
          $dataBase = new DataBase();
          $conection = $dataBase->conection();
    
          $id = $args['id'];
          $platformName = json_decode($request->getBody());
          
          $sqlQueryID = "SELECT * FROM plataformas WHERE id = $id";
          
          $query = $conection->query($sqlQueryID);
          $valid = $query->fetch(PDO::FETCH_ASSOC);
    
    
          if(!$valid || $platformName->nombre != "" || !empty($platformName)){
            
            $sqlQueryUpdate = "UPDATE plataforma SET nombre = '$platformName->nombre' WHERE id = $id";  
            
            $query = $conection -> query($sqlQueryUpdate);     
            
            $response->getBody()->write(json_encode(['mensaje'=>"Plataforma actualizada con exito!."]));
            $query = null;
            $conection = null;
            return $response->withHeader("Content-Type","application/json")->withStatus(200);

          }else{
            
            $response->getBody()->write(json_encode(['mensaje'=>"ID inexistente o campo 'nombre' vacio."]));
            $query = null;
            $conection = null;
            return $response->withHeader("Content-Type","application/json")->withStatus(404);
            
            
          }
          
        }catch(PDOException $e){
          $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
          
          //Caso de ser una mala consulta devuelve 400 BAD REQUEST
          return $response->withHeader("content-type","application/json")->withStatus(400);
        }
        
      });
      //Borrar plataforma
      $app->delete('/Entrega2/plataformas.php{id}', function (Request $request, Response $response,$args) {
        try{
          $db = new DataBase();
          $conexion = $db->conection();
          $id = $args['id'];      
          $sqlQueryID = "SELECT * FROM plataformas WHERE id = $id";
          
          $query = $conexion->query($sqlQueryID);
          $valid = $query->fetch(PDO::FETCH_ASSOC);

          if($valid == null){
            
            $query = null;
            $conexion = null;
            
            $response->getBody()->write(json_encode(['mensaje'=>"ID inexistente."]));
            return $response->withHeader("Content-Type","application/json")->withStatus(404);
          }else{
    
            $sqlQueryUpdate = "DELETE FROM plataformas WHERE id = $id";  
            
            $query = $conexion -> query($sqlQueryUpdate);     
            
            $response->getBody()->write(json_encode(['mensaje'=>"Genero borrado con exito!."]));
            
            $query = null;
            $conexion = null;
            return $response->withHeader("Content-Type","application/json")->withStatus(200);
            
            
          }
        }catch(PDOException $e){
          $response-> getBody()->write(json_encode(['mensaje'=>$e->getMessage()]));
          
          //Caso de ser una mala consulta devuelve 400 BAD REQUEST
          return $response->withHeader("content-type","application/json")->withStatus(400);
        }
        
      });
      
    $app->run();
?>

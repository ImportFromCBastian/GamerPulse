<?php 

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  use App\Models\Db as DataBase;
  use App\Models\Platform;
  require __DIR__ . '/vendor/autoload.php';

  $app = AppFactory::create();

  $conexion = new DataBase();
  
  $app -> get('/games',function (Request $request, Response $response, $args){
    $response -> getBody() -> write("Hello World!");
    return $response;
  });

  $app -> run();

?>
<?php 

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  use App\Models\Db as DataBase;

  require __DIR__ . '/vendor/autoload.php';

  $app = AppFactory::create();
  
  $conection = new DataBase();
  


  $app-> get('/GamerPulse/HelloWorld',function(Request $request, Response $response){
    $response -> getBody() -> write("Hello World");
    return $response;
   
  });

  $app -> run();

?>
<?php 
  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;
  use App\Models\Db as DataBase;

  use App\Controllers\GenderController;
  use App\Controllers\PlatformController;
  use App\Controllers\GameController;
  
  require __DIR__ . '/vendor/autoload.php';
  
  
  $app = AppFactory::create();
  $genderController = new GenderController();
  $platformController = new PlatformController();
  $gameController = new GameController();

  $app->addRoutingMiddleware();
  $app->addErrorMiddleware(false,true,false);
  
  //GET ALL GENDERS == READ
  $app->get('/GamerPulse/genders', function (Request $request, Response $response) {
    $GLOBALS['genderController']->getAllGenders($request,$response);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['genderController']->getStatus());

  });

  //Add new gender == CREATE
  $app->post('/GamerPulse/genders', function (Request $request, Response $response) {
    $GLOBALS['genderController']->postGender($request,$response);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['genderController']->getStatus());

  });
   
  //Update new gender == UPDATE
  $app->put('/GamerPulse/genders/{id}', function (Request $request, Response $response,$args) {
    $GLOBALS['genderController']->putGender($request,$response,$args);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['genderController']->getStatus());
    
  });
  
  //DELETE GENDER
  $app->delete('/GamerPulse/genders/{id}', function (Request $request, Response $response,$args) {
    $GLOBALS['genderController']->deleteGender($request,$response,$args);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['genderController']->getStatus());

  });

  //GET PLATAFORMS
  $app -> get('/GamerPulse/plataformas', function(Request $request, Response $response){
    $GLOBALS['platformController']->getAllPlatforms($request,$response);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['platformController']->getStatus());
    
  });


  //Crear plataforma
  $app->post('/GamerPulse/plataformas',function (Request $request, Response $response){
    $GLOBALS['platformController']->postPlatform($request,$response);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['platformController']->getStatus());

  });


  //Actualizar Plataforma
  $app->put('/GamerPulse/plataformas/{id}', function (Request $request, Response $response,$args) {
    $GLOBALS['platformController']->putPlatform($request,$response,$args);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['platformController']->getStatus());
    
  });


  //Borrar plataforma
  $app->delete('/GamerPulse/plataformas/{id}', function (Request $request, Response $response,$args) {
    $GLOBALS['platformController']->deletePlatform($request,$response,$args);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['platformController']->getStatus());

  });

  //GET ALL GAMES IN DB OR IF THERE ARE PARAMETERS FETCH THOSE
  $app->get('/GamerPulse/games',function(Request $request, Response $response){
    $GLOBALS['gameController']->getGames($request,$response);
    return $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['gameController']->getStatus());
  });


  //DELETE A GAME FROM THE DB
  $app->delete('/GamerPulse/games/{id}',function(Request $request, Response $response,$args){
    $GLOBALS['gameController']->deleteGame($request,$response,$args);
    return  $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['gameController']->getStatus());
  });

  $app->post('/GamerPulse/games', function(Request $request, Response $response){
    $GLOBALS['gameController']->postGame($request,$response);
    return $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['gameController']->getStatus());
  });

  $app->put('/GamerPulse/games/{id}', function(Request $request, Response $response,$args){
    $GLOBALS['gameController']->putGame($request,$response,$args);
    return $response->withHeader("Content-Type","application/json")->withStatus($GLOBALS['gameController']->getStatus());
  });

  $app->run();
  
?>

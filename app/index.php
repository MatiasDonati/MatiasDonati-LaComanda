<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

// Ver esto para MW.
// use Slim\Psr7\Response;


require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';


require_once './middlewares/UsuarioMiddleware.php';
require_once './middlewares/PedidosMiddleware.php';
require_once './middlewares/ModificarPedidosMiddleware.php';
require_once './middlewares/MesaMiddleware.php';
// require_once './middlewares/ProductoMiddleware.php';



// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Set base path 
// Esto por si lo abro directamente con Xampp , en postan poner "http://localhost//Programacion/LaComanda/app" , la misma ruta.
$app->setBasePath('/Programacion/LaComanda/app');

//Si es por comando
// ```sh
// cd C:\<ruta-del-repo-clonado>
// composer update
// php -S localhost:666 -t app
// ```

// - Abrir desde http://localhost:666/ en POSTMAN !

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');

    //Si uso funcion static lo llamo de esta manera.
    // $group->post('[/]', \UsuarioController::class . ':CargarUno')->add(\CrearUsuarioRolMiddleware::class . ":CrearUsuarioMiddleware");
    //Si en el MW uso __invoke lo llamo instanciando la clase directamente.
    $group->post('[/]', \UsuarioController::class . ':CargarUno')->add(new UsuarioRolMiddleware());
    
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno')->add(new UsuarioRolMiddleware());
  });

  $app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');
    $group->get('/{nombre}', \ProductoController::class . ':TraerUno');
    $group->post('[/]', \ProductoController::class . ':CargarUno');
    $group->put('/{id}', \ProductoController::class . ':ModificarUno');
    $group->delete('/{id}', \ProductoController::class . ':BorrarUno');
  });

  $app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos');
    $group->get('/{id}', \MesaController::class . ':TraerUno');
    $group->post('[/]', \MesaController::class . ':CargarUno')->add(new MesaMiddleware());
    $group->put('/{id}', \MesaController::class . ':ModificarUno');
    $group->delete('/{id}', \MesaController::class . ':BorrarUno');
  });


  $app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \PedidoController::class . ':TraerTodos');
    $group->get('/{id}', \PedidoController::class . ':TraerUno');
    $group->post('[/]', \PedidoController::class . ':CargarUno')->add(new CrearPedidoMiddleware());
    $group->put('/{id}', \PedidoController::class . ':ModificarUno')->add(new ModificarPedidosMiddleware());
    $group->delete('/{id}', \PedidoController::class . ':BorrarUno');
  });



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Bienvenido a La Comanda!"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
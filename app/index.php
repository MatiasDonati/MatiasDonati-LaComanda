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

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
// require_once './middlewares/Logger.php';


// CREATE PDF // Paquete de composer para PDF
// CREATE PDF // Paquete de composer para PDF
// CREATE PDF // Paquete de composer para PDF


require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/AuthController.php';
require_once './controllers/ProductosPedidosController.php';

require_once './middlewares/UsuarioMiddleware.php';
require_once './middlewares/PedidosMiddleware.php';
require_once './middlewares/ModificarPedidosMiddleware.php';
require_once './middlewares/MesaMiddleware.php';
// require_once './middlewares/AuthMiddleware.php';

require_once './utils/AutentificadorJWT.php';


// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// En POSTMAN poner "http://localhost//Programacion/LaComanda/app" , la misma ruta.
$app->setBasePath('/Programacion/LaComanda/app');

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno')->add(new RolMiddleware(['socio']));
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno')->add(new RolMiddleware(['socio']));
  });

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{nombre}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
  $group->put('/{id}', \ProductoController::class . ':ModificarUno');
  $group->delete('/{id}', \ProductoController::class . ':BorrarUno');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('/csv', \MesaController::class . ':SubirCsv')->add(new RolMiddleware(['socio']));
  $group->get('/csv', \MesaController::class . ':DescargarCsv')->add(new RolMiddleware(['socio']));
  $group->get('[/]', \MesaController::class . ':TraerTodos')->add(new RolMiddleware(['socio']));
  $group->get('/{id}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno')->add(new MesaMiddleware())->add(new RolMiddleware(['socio']));
  $group->put('/{id}', \MesaController::class . ':ModificarUno')->add(new RolMiddleware(['mozo']));
  $group->delete('/{id}', \MesaController::class . ':BorrarUno')->add(new RolMiddleware(['socio']));
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/{id}', \PedidoController::class . ':TraerUno')->add(new ConsultarPedidoMiddleware());

  $group->get('/numeroDePedido/{numeroDePedido}', \PedidoController::class . ':TraerUnoPorNumeroDePedido');
  
  // Agregar los MW
  // Agregar los MW

  $group->post('[/]', \PedidoController::class . ':CargarUno')->add(new CrearPedidoMiddleware())->add(new RolMiddleware(['mozo']));
  $group->put('/{id}', \PedidoController::class . ':ModificarUno')->add(new ModificarPedidosMiddleware())->add(new RolMiddleware(['mozo']));
  $group->delete('/{id}', \PedidoController::class . ':BorrarUno');
  $group->post('/tomarFoto', \PedidoController::class . ':TomarFoto')->add(new RolMiddleware(['mozo'])); 
  
  // Agregar MW para campos numeroPed y foto q no eaten vacios
  // Agregar MW para campos numeroPed y foto q no eaten vacios

});

$app->get('/productosPedidos', \ProductosPedidosController::class . ':ObtenerTodos');

$app->get('/productosPedidos/comida', \ProductosPedidosController::class . ':ObtenerProductosPorComida')->add(new RolMiddleware(['cocinero']));
$app->get('/productosPedidos/comidaPendiente', \ProductosPedidosController::class . ':ObtenerProductosPorComidaPendiente')->add(new RolMiddleware(['cocinero']));

$app->get('/productosPedidos/trago', \ProductosPedidosController::class . ':ObtenerProductosPorTrago')->add(new RolMiddleware(['bartender']));
$app->get('/productosPedidos/tragoPendiente', \ProductosPedidosController::class . ':ObtenerProductosPorTragoPendiente')->add(new RolMiddleware(['bartender']));
$app->get('/productosPedidos/prepararTrago/{id}', \ProductosPedidosController::class . ':PrepararProducto');

$app->get('/productosPedidos/cerveza', \ProductosPedidosController::class . ':ObtenerProductosPorCerveza')->add(new RolMiddleware(['cervecero']));
$app->get('/productosPedidos/cervezaPendiente', \ProductosPedidosController::class . ':ObtenerProductosPorCervezaPendiente')->add(new RolMiddleware(['cervecero']));

$app->get('/productosPedidos/{numeroDePedido}', \ProductosPedidosController::class . ':ObtenerPorPedido');
$app->get('/productosPedidos/tipo/{tipoDeProducto}', \ProductosPedidosController::class . ':ObtenerProductosPorTipo');



$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Bienvenido a La Comanda!"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

// JVT - Token //  Crear - Verificar- Obtener datos
$app->group('/auth', function (RouteCollectorProxy $group) {
  $group->post('/crearToken', \AuthController::class . ':CrearToken');
  $group->post('/verificarToken', \AuthController::class . ':VerificarToken');
  $group->post('/obtenerDatos', \AuthController::class . ':ObtenerDatos');
});

$app->run();
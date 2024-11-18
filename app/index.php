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
require_once './utils/AutentificadorJWT.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/AuthController.php';
require_once './controllers/ProductosPedidosController.php';
require_once './controllers/EncuestaController.php';

require_once './middlewares/UsuarioMiddleware.php';
require_once './middlewares/PedidosMiddleware.php';
require_once './middlewares/MesaMiddleware.php';
require_once './middlewares/ProductosMiddleWare.php';
require_once './middlewares/PreparacionProdMiddleware.php';

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

    // Obtener ingreso de usuarios cuando se Ingresaron por fecha puntual o entre dos fechas..
    $group->get('/obtenerIngresos', \UsuarioController::class . ':obtenerIngresos');

    $group->get('[/]', \UsuarioController::class . ':TraerTodos');
    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
    $group->post('[/]', \UsuarioController::class . ':CargarUno')->add(new UsuarioMiddleware(['usuario', 'clave', 'rol']));
    $group->put('/{id}', \UsuarioController::class . ':ModificarUno')->add(new UsuarioMiddleware(['usuario', 'clave', 'rol']));
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');

    $group->get('/suspender/{id}', \UsuarioController::class . ':suspenderUsuario')->add(new RolMiddleware(['socio']));

  })->add(new RolMiddleware(['socio']));

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':TraerTodos')->add(new RolMiddleware(['socio', 'mozo']));
  $group->get('/{nombre}', \ProductoController::class . ':TraerUno')->add(new RolMiddleware(['socio', 'mozo']));
  $group->post('[/]', \ProductoController::class . ':CargarUno')->add(new RolMiddleware(['socio', 'mozo']))->add(new CamposMiddleWare(['nombre', 'tipo', 'precio']));
  $group->put('/{id}', \ProductoController::class . ':ModificarUno')->add(new RolMiddleware(['socio']))->add(new CamposMiddleWare(['nombre', 'tipo', 'precio']));
  $group->delete('/{id}', \ProductoController::class . ':BorrarUno')->add(new RolMiddleware(['socio']));
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->post('/csv', \MesaController::class . ':SubirCsv')->add(new RolMiddleware(['socio']));
  $group->get('/csv', \MesaController::class . ':DescargarCsv')->add(new RolMiddleware(['socio']));
  $group->get('/pdf', \MesaController::class . ':generarPDF')->add(new RolMiddleware(['socio']));
  $group->get('[/]', \MesaController::class . ':TraerTodos')->add(new RolMiddleware(['socio']));
  $group->get('/{id}', \MesaController::class . ':TraerUno');
  $group->post('[/]', \MesaController::class . ':CargarUno')->add(new RolMiddleware(['socio']));
  $group->put('/{id}', \MesaController::class . ':ModificarUno')->add(new RolMiddleware(['mozo', 'socio']))->add(new MesaMiddleware());
  $group->delete('/{id}', \MesaController::class . ':BorrarUno')->add(new RolMiddleware(['socio']));
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {

  $group->post('/verPedidoDeUnaMesa', \PedidoController::class . ':VerPedidoDeMesa');
  $group->get('[/]', \PedidoController::class . ':TraerTodos');
  $group->get('/{id}', \PedidoController::class . ':TraerUno')->add(new ConsultarPedidoMiddlewareId());
  $group->get('/numeroDePedido/{numeroDePedido}', \PedidoController::class . ':TraerUnoPorNumeroDePedido')->add(new ConsultarPedidoMiddlewareNumeroDePedido());
  $group->post('[/]', \PedidoController::class . ':CargarUno')->add(new CrearPedidoMiddleware())->add(new RolMiddleware(['mozo']));
  $group->put('/{id}', \PedidoController::class . ':ModificarUno')->add(new RolMiddleware(['mozo']))->add(new CamposPedidosMiddleware(['estado']));
  $group->delete('/{id}', \PedidoController::class . ':BorrarUno')->add(new RolMiddleware(['mozo', 'socio']));
  $group->post('/tomarFoto', \PedidoController::class . ':TomarFoto')->add(new RolMiddleware(['mozo']))->add(new CamposPedidosMiddleware(['numeroDePedido', 'foto'])); 
});

// // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR 
// $app->get('/productosPedidos', \ProductosPedidosController::class . ':ObtenerTodos');
// $app->get('/productosPedidos/comida', \ProductosPedidosController::class . ':ObtenerProductosPorComida')->add(new RolMiddleware(['cocinero', 'socio']));
// $app->get('/productosPedidos/trago', \ProductosPedidosController::class . ':ObtenerProductosPorTrago')->add(new RolMiddleware(['bartender', 'socio']));
// $app->get('/productosPedidos/cerveza', \ProductosPedidosController::class . ':ObtenerProductosPorCerveza')->add(new RolMiddleware(['cervecero', 'socio']));
// // MAs dinamico 'pendiente', 'en preparacion' o 'listo para servir'
// $app->get('/productosPedidos/trago/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorTrago')->add(new RolMiddleware(['bartender', 'socio']));
// $app->get('/productosPedidos/cerveza/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorCerveza')->add(new RolMiddleware(['cervecero', 'socio']));
// $app->get('/productosPedidos/comida/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorComida')->add(new RolMiddleware(['cocinero', 'socio']));

// $app->post('/productosPedidos/prepararTrago/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['bartender']));
// $app->post('/productosPedidos/prepararComida/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['cocinero']));
// $app->post('/productosPedidos/prepararCerveza/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['cervecero']));

// $app->get('/productosPedidos/listoParaServirTrago/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['bartender']));
// $app->get('/productosPedidos/listoParaServirComida/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['cocinero']));
// $app->get('/productosPedidos/listoParaServirCerveza/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['cervecero']));

// $app->get('/productosPedidos/{numeroDePedido}', \ProductosPedidosController::class . ':ObtenerPorPedido');
// $app->get('/productosPedidos/tipo/{tipoDeProducto}', \ProductosPedidosController::class . ':ObtenerProductosPorTipo');
// // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR // AGRUPAR 

$app->group('/productosPedidos', function ($group) {
  $group->get('[/]', \ProductosPedidosController::class . ':ObtenerTodos');
  
  $group->get('/comida', \ProductosPedidosController::class . ':ObtenerProductosPorComida')->add(new RolMiddleware(['cocinero', 'socio']));
  $group->get('/trago', \ProductosPedidosController::class . ':ObtenerProductosPorTrago')->add(new RolMiddleware(['bartender', 'socio']));
  $group->get('/cerveza', \ProductosPedidosController::class . ':ObtenerProductosPorCerveza')->add(new RolMiddleware(['cervecero', 'socio']));

  $group->get('/trago/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorTrago')->add(new RolMiddleware(['bartender', 'socio']));
  $group->get('/cerveza/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorCerveza')->add(new RolMiddleware(['cervecero', 'socio']));
  $group->get('/comida/{estado}', \ProductosPedidosController::class . ':ObtenerProductosPorComida')->add(new RolMiddleware(['cocinero', 'socio']));

  $group->post('/prepararTrago/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['bartender']))->add(new PreparacionProdMiddleware());
  $group->post('/prepararComida/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['cocinero']))->add(new PreparacionProdMiddleware());
  $group->post('/prepararCerveza/{id}', \ProductosPedidosController::class . ':PrepararProducto')->add(new RolMiddleware(['cervecero']))->add(new PreparacionProdMiddleware());

  $group->get('/listoParaServirTrago/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['bartender']));
  $group->get('/listoParaServirComida/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['cocinero']));
  $group->get('/listoParaServirCerveza/{id}', \ProductosPedidosController::class . ':ListoParaServir')->add(new RolMiddleware(['cervecero']));

  $group->get('/{numeroDePedido}', \ProductosPedidosController::class . ':ObtenerPorPedido');
  $group->get('/tipo/{tipoDeProducto}', \ProductosPedidosController::class . ':ObtenerProductosPorTipo');


  // Estadisticas  --- en usuarios esta la parte del login de usuarios por fecha
  $group->get('/cantidadOperaciones/{tipoProducto}', \ProductosPedidosController::class . ':ObtenerCantidadDeOperacionesPorTipo');
  $group->get('/cantidadOperaciones/porEmpleado/{tipoProducto}', \ProductosPedidosController::class . ':ListarPorEmpleadoID');
  $group->get('/cantidadOperaciones/porEmpleadoId/{idEmpleado}', \ProductosPedidosController::class . ':OperacionesUnEmpleadoId');
  
});


$app->group('/encuesta', function (RouteCollectorProxy $group) {
	$group->post('[/]', \EncuestaController::class . ':CargarUno')->add(new EncuestaMiddleware())->add(new PedidoIdMiddleware());;
	$group->get('[/]', \EncuestaController::class . ':TraerTodos');
  $group->get('/mejoresComentarios', \EncuestaController::class . ':MejoresComentarios');
});

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
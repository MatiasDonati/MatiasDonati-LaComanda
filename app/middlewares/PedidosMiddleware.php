<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CrearPedidoMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();

        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        if (
            isset($array['mesaId'], $array['tiempoEstimado'], $array['precio'], $array['productos'], $array['cliente']) &&
            !empty($array['mesaId']) &&
            !empty($array['tiempoEstimado']) &&
            !empty($array['precio']) &&
            !empty($array['productos']) &&
            is_array($array['productos']) &&
            !empty($array['cliente'])
        ) {
            return $handler->handle($request);
        } else {
            $payload = json_encode(["mensaje" => "Faltan datos obligatorios o están incompletos."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}


class ConsultarPedidoMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeArgs = $routeContext->getRoute()->getArguments();
        $idPedido = $routeArgs['id'] ?? null;

        if ($idPedido) {
            $pedido = Pedido::obtenerPedido($idPedido);

            if ($pedido) {
                return $handler->handle($request);
            } else {
                $payload = json_encode(["mensaje" => "No existe Pedido con ese ID"]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } else {
            $payload = json_encode(["mensaje" => "ID de Pedido no proporcionado en la ruta"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }

}

///////////////
///////////////
///////////////
///////////////
///////////////
///////////////



class PedidoIdMiddleware
{	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();
		$numerosDePedidos = Pedido::obtenerTodosNumeroDePedido();
		if (isset($params['numeroDePedido'])) {
			if (in_array($params['numeroDePedido'], $numerosDePedidos)) {
				$response = $handler->handle($request);
			} else {
				$payload = json_encode(array("mensaje" => "No existe Pedido con ese Numero De Pedido"));
                $response->getBody()->write($payload);
			}
		} else {
			$payload = json_encode(array("mensaje" => "Falta Numero De Pedido"));
            $response->getBody()->write($payload);
		}


		return $response->withHeader('Content-Type', 'application/json');
	}
}


// class ProductoEnPedidoMiddleware
// {	public function __invoke(Request $request, RequestHandler $handler): Response
// 	{
// 		$response = new Response();
// 		$parametros = $request->getParsedBody();
// 		$id_producto = $parametros['id_producto'];
// 		$id_pedido = $parametros['id_pedido'];
// 		$pedidoProducto = PedidoProductos::BuscarProductoEnPedido($id_producto, $id_pedido);

// 		if (!empty($pedidoProducto)) {

// 			$response = $handler->handle($request);

// 		} else {
// 			$payload = json_encode(array("mensaje" => "No existe ese Producto en el Pedido"));
//             $response->getBody()->write($payload);
// 		}


// 		return $response->withHeader('Content-Type', 'application/json');
// 	}

// }


// class FacturaIdMiddleware
// {	public function __invoke(Request $request, RequestHandler $handler): Response
// 	{
// 		$response = new Response();
// 		$params = $request->getParsedBody();
// 		$ids = Factura::obtenerTodosId();
// 		if (isset($params['id_factura'])) {
// 			if (in_array($params['id_factura'], $ids)) {
// 				$response = $handler->handle($request);
// 			} else {
// 				$payload = json_encode(array("mensaje" => "No existe Factura con ese ID"));
//                 $response->getBody()->write($payload);
// 			}
// 		} else {
// 			$payload = json_encode(array("mensaje" => "Falta ID Factura"));
//             $response->getBody()->write($payload);
// 		}


// 		return $response->withHeader('Content-Type', 'application/json');
// 	}

// }


class EncuestaMiddleware
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$parametros = $request->getParsedBody();

		if (isset($parametros['numeroDePedido']) && isset($parametros['puntuacionMesa']) && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionRestaurante']) && isset($parametros['puntuacionCocinero']) && isset($parametros['comentarios'])) {
			if ($this->validarPuntuaciones($parametros)) {
				$response = $handler->handle($request);
			} else {
				$response->getBody()->write(json_encode(array("mensaje" => "Las puntaciones deben ser entre 1 y 10")));
			}
		} else {
			$response->getBody()->write(json_encode(array("mensaje" => "Faltan campos de la encuesta")));
		}

		return $response->withHeader('Content-Type', 'application/json');
	}

	private function validarPuntuaciones($parametros): bool
    {
        foreach (['puntuacionMesa', 'puntuacionMozo', 'puntuacionRestaurante', 'puntuacionCocinero'] as $parametro) {
            $puntuacion = (int) $parametros[$parametro];
            if ($puntuacion < 1 || $puntuacion > 10) {
                return false;
            }
        }
        return true;
    }

}

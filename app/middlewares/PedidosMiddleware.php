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

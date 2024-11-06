<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CrearPedidoMiddleware

// 
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        if (isset($array['usuario']) && !empty($array['usuario'])) {
            if ($array['usuario'] === 'mozo') {
                return $handler->handle($request);
            } else {
                $payload = json_encode(["mensaje" => "Solo 'mozo' puede generar un pedido."]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
            }
        } else {
            $payload = json_encode(["mensaje" => "Completa el usuario."]);
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

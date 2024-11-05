<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class ModificarPedidosMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $response = new Response();

        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        $payload = json_encode(array("mensaje" => "Depende el Tipo de Producto, depende quien podra modificar el estado del pedido."));
        $response->getBody()->write($payload);
    
            return $response->withHeader('Content-Type', 'application/json');
        }
    
}


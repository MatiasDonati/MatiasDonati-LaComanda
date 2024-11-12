<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;


class ModificarPedidosMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   

                
        echo "Middleware de Modificar Pedido Solo mozos deben poder modificar el estado de los  pedidos." . PHP_EOL;
        return $handler->handle($request);


        // $response = new Response();

        // $json = file_get_contents('php://input');
        // $array = json_decode($json, true);


        // echo 'El estado que queres ingresar es: '.$array['estado'];

        // $payload = json_encode(array("mensaje" => "Depende el Tipo de Producto, depende quien podra modificar el estado del pedido."));
        // $response->getBody()->write($payload);
    
        //     return $response->withHeader('Content-Type', 'application/json');
    }
    
}


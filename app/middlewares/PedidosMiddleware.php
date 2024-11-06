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
        

        if(isset($array['usuario']) && !empty($array['usuario'])){

            if ($array['usuario'] == 'mozo') {
                $response = $handler->handle($request);
            } else {
                $payload = json_encode(array("mensaje" => "Solo 'mozo' puede generar un pedido."));
                $response->getBody()->write($payload);
            }
        }else{
            $payload = json_encode(array("mensaje" => "Completa el usuario."));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MesaMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $response = new Response();
        $params = $request->getParsedBody();

        if (!isset($params['estado']) || !isset($params['codigoDeIdentificacion'])) {
            $payload = json_encode(["mensaje" => "Faltan datos: estado o codigoDeIdentificacion no proporcionados."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        // Rol captado en metodo porque aca no lo tomaba    
        // $rolUsuario = $request->getAttribute('rolUsuario');
        // var_dump($rolUsuario);
        // if($params['estado'] === 'cerrada' && $rolUsuario != 'socio'){
        //     $payload = json_encode(["mensaje" => "El rol no habilita cerrar la mesa. Solo socios."]);
        //     $response->getBody()->write($payload);
        //     return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        // }

        $mesaExistente = Mesa::obtenerMesaPorCodigoDeIdentificacion($params['codigoDeIdentificacion']);
        if(!$mesaExistente){
            $payload = json_encode(["mensaje" => "El codigo de la Mesa es Incorrecto."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $estadosValidos = ['con cliente esperando pedido', 'con cliente comiendo', 'con cliente pagando', 'cerrada'];

        if (!in_array($params['estado'], $estadosValidos)) {
            $payload = json_encode([
                "mensaje" => "El estado no es válido.",
                "estados validos" => implode(", ", $estadosValidos)
            ]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $handler->handle($request);
    }
}

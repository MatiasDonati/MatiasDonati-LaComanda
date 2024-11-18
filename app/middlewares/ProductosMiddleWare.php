<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CamposMiddleWare
{
    private $parametrosRequeridos;
    private $tiposPermitidos = ['cerveza', 'comida', 'trago'];

    public function __construct(array $parametrosRequeridos)
    {
        $this->parametrosRequeridos = $parametrosRequeridos;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $response = new Response();
        $params = $request->getParsedBody();

        foreach ($this->parametrosRequeridos as $parametro) {
            if (!isset($params[$parametro])) {
                $payload = json_encode(["mensaje" => "Faltan datos: $parametro no proporcionado."]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        }

        if (isset($params['tipo']) && !in_array($params['tipo'], $this->tiposPermitidos)) {
            $payload = json_encode(["mensaje" => "Tipo errado. Los tipos permitidos son: " . implode(', ', $this->tiposPermitidos)]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $handler->handle($request)->withHeader('Content-Type', 'application/json');
    }
}
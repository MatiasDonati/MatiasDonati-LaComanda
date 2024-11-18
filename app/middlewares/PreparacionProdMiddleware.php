<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class PreparacionProdMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();

        $tiempoEstimado = $request->getParsedBody()['tiempoEstimado'] ?? null;
        
        if ($tiempoEstimado) {
            return $handler->handle($request)->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(["mensaje" => "completa tiempoEstimado"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}
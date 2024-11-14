<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class MesaMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        
        echo "Middleware de Mesa. Para dar de alta una mesa debes ser Socio." . PHP_EOL;
        return $handler->handle($request);
    }

}
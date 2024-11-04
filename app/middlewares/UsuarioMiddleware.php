<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

// Con funcion magica __invoke
class CrearUsuarioRolMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $response = new Response();
        $params = $request->getParsedBody();
        

        if(isset($params['rol'], $params['clave'], $params['usuario']) && !empty($params['rol'])&& !empty($params['clave'])&& !empty($params['usuario'])){
            
            $rol = $params['rol'];

            if ($rol === 'socio' || $rol === 'mozo' || $rol === 'cocinero' || $rol === 'cervecero' || $rol === 'bartender') {
                $response = $handler->handle($request);
            } else {
                
                $payload = json_encode(array("mensaje" => "Rol incorrecto."));
                $response->getBody()->write($payload);
            }
        }else{
            $payload = json_encode(array("mensaje" => "Completa los datos."));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}

// // Con funcion statica nomarl
// class CrearUsuarioRolMiddleware{

//     public static function CrearUsuarioMiddleware($request, $handler){
        
//         echo "Entro al MW\n";

//         $params = $request->getParsedBody();


//         if(!isset($params['usuario'],$params['clave'], $params['rol']) || empty($params['usuario'])|| empty($params['clave'])|| empty($params['rol'])){
            

//             $response = new Response();

//             $response->getBody()->write('{error: "No no no ..  datos incorrectos"}');
//             return $response
//             ->withHeader('Content-Type', 'application/json')
//             ->withStatus(400);

//         }

//         $response = $handler->handle($request);

//         echo "Salgo del MW\n";

//         return $response;
//     }

// }



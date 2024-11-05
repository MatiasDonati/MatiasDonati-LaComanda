<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

// Con función mágica __invoke
class CrearUsuarioRolMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {   
        $response = new Response();
        $params = $request->getParsedBody();
        $method = $request->getMethod();

        if ($method === 'POST') {

            if (isset($params['rol'], $params['clave'], $params['usuario']) && 
                !empty($params['rol']) && !empty($params['clave']) && !empty($params['usuario'])) {
                
                $rol = $params['rol'];

                if (in_array($rol, ['socio', 'mozo', 'cocinero', 'cervecero', 'bartender'])) {

                    return $handler->handle($request); 

                } else {

                    $payload = json_encode(["mensaje" => "Rol incorrecto."]);
                    $response->getBody()->write($payload);

                    return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
                }
            } else {

                $payload = json_encode(["mensaje" => "Completa los datos."]);
                $response->getBody()->write($payload);

                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        } 
        elseif ($method === 'DELETE') {

            
            echo "hola, entrando al MW de Delete\nSolo SOCIO deberia borrar.";
            return $handler->handle($request);

            // // Ver Poque no esta andando bien, no se si esta bien mandar por el cuerpo del delete info.

            // echo $params['rol'];

            // if (isset($params['rol']) && !empty($params['rol'])) {
            //     if ($params['rol'] === 'socio') {

            //         return $handler->handle($request);
            //     }
            // }

            // $payload = json_encode(["mensaje" => "Solo los socios pueden eliminar Usuarios."]);
            // $response->getBody()->write($payload);

            // return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
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



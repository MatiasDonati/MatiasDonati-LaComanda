<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UsuarioRolMiddleware
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

// class RolMiddleware
// {
//     private $rolesPermitidos;

//     public function __construct(array $rolesPermitidos)
//     {
//         $this->rolesPermitidos = $rolesPermitidos;
//     }

//     public function __invoke(Request $request, RequestHandler $handler): Response
//     {
//         $response = new Response();

//         $authHeader = $request->getHeader('token');
//         if (!$authHeader || !isset($authHeader[0])) {
//             $payload = json_encode(["mensaje" => "Token no proporcionado."]);
//             $response->getBody()->write($payload);
//             return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
//         }

//         $token = $authHeader[0];

//         try {
//             AutentificadorJWT::VerificarToken($token);
//             $data = AutentificadorJWT::ObtenerData($token);

//             if (in_array($data->rol, $this->rolesPermitidos)) {
//                 return $handler->handle($request);
//             } else {
//                 $payload = json_encode(["mensaje" => "Acceso denegado. No tienes el rol necesario para realizar esta acción."]);
//                 $response->getBody()->write($payload);
//                 return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
//             }
//         } catch (Exception $e) {
//             $payload = json_encode(["mensaje" => "Token inválido o expirado.", "error" => $e->getMessage()]);
//             $response->getBody()->write($payload);
//             return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
//         }
//     }
// }

class RolMiddleware
{
    private $rolesPermitidos;

    public function __construct(array $rolesPermitidos)
    {
        $this->rolesPermitidos = $rolesPermitidos;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();

        $authHeader = $request->getHeader('token');
        if (!$authHeader || !isset($authHeader[0])) {
            $payload = json_encode(["mensaje" => "Token no proporcionado."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $token = $authHeader[0];

        try {
            AutentificadorJWT::VerificarToken($token);
            $data = AutentificadorJWT::ObtenerData($token);

            if (in_array($data->rol, $this->rolesPermitidos)) {

                // agregar el rol a la request para poder captarlo desde metodo, y conocerel rol
                // agregar el rol a la request para poder captarlo desde metodo, y conocerel rol
                
                $request = $request->withAttribute('rolUsuario', $data->rol);
                return $handler->handle($request);
            } else {
                $payload = json_encode(["mensaje" => "Acceso denegado. No tienes el rol necesario para realizar esta acción."]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
            }
        } catch (Exception $e) {
            $payload = json_encode(["mensaje" => "Token inválido o expirado.", "error" => $e->getMessage()]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }
    }
}

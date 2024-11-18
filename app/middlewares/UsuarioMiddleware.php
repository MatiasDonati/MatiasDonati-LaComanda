<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class UsuarioMiddleware
{
    private $parametrosRequeridos;

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

        $rol = $params['rol'];

        if ($rol === 'mozo' || $rol === 'bartender'|| $rol === 'cocinero'|| $rol === 'cervecero') {
            return $handler->handle($request)->withHeader('Content-Type', 'application/json');
        } else {
            $payload = json_encode(["mensaje" => "Rol inexistente."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
        }
    }
}

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

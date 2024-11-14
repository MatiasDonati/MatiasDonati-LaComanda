<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthController
{
    public function CrearToken(Request $request, Response $response): Response
    {
        $datos = $request->getParsedBody();
        try {
            $token = AutentificadorJWT::CrearToken($datos);
            $response->getBody()->write(json_encode(['token' => $token]));
        } catch (Exception $e) {
            $response = $response->withStatus(500);
            $response->getBody()->write(json_encode(['error' => 'Error al crear el token: ' . $e->getMessage()]));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function VerificarToken(Request $request, Response $response): Response
    {
        $params = $request->getParsedBody();
        try {
            AutentificadorJWT::VerificarToken($params['token']);
            $response->getBody()->write(json_encode(['mensaje' => 'Token válido']));
        } catch (Exception $e) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerDatos(Request $request, Response $response): Response
    {
        $params = $request->getParsedBody();
        try {
            $data = AutentificadorJWT::ObtenerData($params['token']);
            $response->getBody()->write(json_encode(['data' => $data]));
        } catch (Exception $e) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}

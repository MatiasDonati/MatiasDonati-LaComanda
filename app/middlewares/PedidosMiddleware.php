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

        if (
            isset($array['mesaId'], $array['tiempoEstimado'], $array['precio'], $array['productos'], $array['cliente']) &&
            !empty($array['mesaId']) &&
            !empty($array['tiempoEstimado']) &&
            !empty($array['precio']) &&
            !empty($array['productos']) &&
            is_array($array['productos']) &&
            !empty($array['cliente'])
        ) {
            return $handler->handle($request);
        } else {
            $payload = json_encode(["mensaje" => "Faltan datos obligatorios o están incompletos."]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}

class ConsultarPedidoMiddlewareId
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeArgs = $routeContext->getRoute()->getArguments();
        $idPedido = $routeArgs['id'] ?? null;

        if ($idPedido) {
            $pedido = Pedido::obtenerPedido($idPedido);

            if ($pedido) {
                return $handler->handle($request);
            } else {
                $payload = json_encode(["mensaje" => "No existe Pedido con ese ID"]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } else {
            $payload = json_encode(["mensaje" => "ID de Pedido no proporcionado en la ruta"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}

class ConsultarPedidoMiddlewareNumeroDePedido
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeArgs = $routeContext->getRoute()->getArguments();
        $numerosDePedido = $routeArgs['numeroDePedido'] ?? null;

        if ($numerosDePedido) {
            $pedido = Pedido::obtenerPedidoPorNumeroDePedido($numerosDePedido);

            if ($pedido) {
                return $handler->handle($request);
            } else {
                $payload = json_encode(["mensaje" => "No existe Pedido con ese Numero de Pedido"]);
                $response->getBody()->write($payload);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } else {
            $payload = json_encode(["mensaje" => "Numero de Pedido no proporcionado en la ruta"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}

class PedidoIdMiddleware
{	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$params = $request->getParsedBody();
		$numerosDePedidos = Pedido::obtenerTodosNumeroDePedido();
		if (isset($params['numeroDePedido'])) {
			if (in_array($params['numeroDePedido'], $numerosDePedidos)) {
				$response = $handler->handle($request);
			} else {
				$payload = json_encode(array("mensaje" => "No existe Pedido con ese Numero De Pedido"));
                $response->getBody()->write($payload);
			}
		} else {
			$payload = json_encode(array("mensaje" => "Falta Numero De Pedido"));
            $response->getBody()->write($payload);
		}


		return $response->withHeader('Content-Type', 'application/json');
	}
}

class EncuestaMiddleware
{
	public function __invoke(Request $request, RequestHandler $handler): Response
	{
		$response = new Response();
		$parametros = $request->getParsedBody();

		if (isset($parametros['numeroDePedido']) && isset($parametros['puntuacionMesa']) && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionRestaurante']) && isset($parametros['puntuacionCocinero']) && isset($parametros['comentarios'])) {
			if ($this->validarPuntuaciones($parametros)) {
				$response = $handler->handle($request);
			} else {
				$response->getBody()->write(json_encode(array("mensaje" => "Las puntaciones deben ser entre 1 y 10")));
			}
		} else {
			$response->getBody()->write(json_encode(array("mensaje" => "Faltan campos de la encuesta")));
		}

		return $response->withHeader('Content-Type', 'application/json');
	}

	private function validarPuntuaciones($parametros): bool
    {
        foreach (['puntuacionMesa', 'puntuacionMozo', 'puntuacionRestaurante', 'puntuacionCocinero'] as $parametro) {
            $puntuacion = (int) $parametros[$parametro];
            if ($puntuacion < 1 || $puntuacion > 10) {
                return false;
            }
        }
        return true;
    }

}

class CamposPedidosMiddleware
{
    private $camposRequeridos;

    public function __construct(array $camposRequeridos)
    {
        $this->camposRequeridos = $camposRequeridos;
    }

    public function __invoke($request, $handler)
    {
        $params = $request->getParsedBody();
        $camposFaltantes = [];

        foreach ($this->camposRequeridos as $campo) {
            if (!isset($params[$campo])) {
                $camposFaltantes[] = $campo;
            }
        }

        if (!empty($camposFaltantes)) {
            $response = new \Slim\Psr7\Response();
            $payload = json_encode([
                "mensaje" => "Faltan campos requeridos: " . implode(", ", $camposFaltantes)
            ]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $handler->handle($request);
    }
}
class ValidarArchivoMiddleware
{
    private $nombreArchivo;

    public function __construct(string $nombreArchivo)
    {
        $this->nombreArchivo = $nombreArchivo;
    }

    public function __invoke($request, $handler)
    {
		$response = new Response();
        $uploadedFiles = $request->getUploadedFiles();

        if (!isset($uploadedFiles[$this->nombreArchivo])) {
            $payload = json_encode([
                "mensaje" => "No se envió el archivo requerido: {$this->nombreArchivo}."
            ]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $archivo = $uploadedFiles[$this->nombreArchivo];
        if ($archivo->getError() !== UPLOAD_ERR_OK) {
            $payload = json_encode([
                "mensaje" => "Hubo un error al cargar el archivo: {$this->nombreArchivo}."
            ]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        return $handler->handle($request);
    }
}


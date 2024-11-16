<?php

require_once './models/ProductosPedidos.php';

class ProductosPedidosController
{
    public static function ObtenerTodos($request, $response, $args)
    {
        $productosPedidos = ProductosPedidos::TraerTodosLosProductosPedidos();
        $response->getBody()->write(json_encode($productosPedidos));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public static function ObtenerPorPedido($request, $response, $args)
    {
        $numeroDePedido = $args['numeroDePedido'];
        $productos = ProductosPedidos::ObtenerProductosPorPedido($numeroDePedido);
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos para el pedido especificado"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public static function ObtenerProductosPorTipo($request, $response, $args)
    {
        $tipoDeProducto = $args['tipoDeProducto'];
        $productos = ProductosPedidos::ObtenerProductosPorTipo($tipoDeProducto);
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo $tipoDeProducto"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public static function ObtenerProductosGenerico($request, $response, $tipo, $estado = null)
    {

        $productosValidos = ['pendiente','en preparacion',  'listo para servir'];

        if ($estado !== null && !in_array($estado, $productosValidos)) {
            $mensaje = ["mensaje" => "El estado '$estado' no existe. Los estados son: pendiente, en preparacion y listo para servir."];
            $response->getBody()->write(json_encode($mensaje));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $productos = ($estado === 'pendiente' || $estado === 'en preparacion' || $estado === 'listo para servir')
            ? ProductosPedidos::ObtenerProductosPorEstadoYTipo($tipo, $estado)
            : ProductosPedidos::ObtenerProductosPorTipo($tipo);

        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $mensaje = ["mensaje" => "No se encontraron productos de tipo $tipo" . ($estado ? " $estado" : "")];
            $response->getBody()->write(json_encode($mensaje));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public static function ObtenerProductosPorComida($request, $response, $args)
    {
        $estado = $args['estado'] ?? null;
        return self::ObtenerProductosGenerico($request, $response, 'comida', $estado);
    }

    public static function ObtenerProductosPorTrago($request, $response, $args)
    {
        $estado = $args['estado'] ?? null;
        return self::ObtenerProductosGenerico($request, $response, 'trago', $estado);
    }
    
    public static function ObtenerProductosPorCerveza($request, $response, $args)
    {
        $estado = $args['estado'] ?? null;
        return self::ObtenerProductosGenerico($request, $response, 'cerveza', $estado);

    }


    public static function PrepararProducto($request, $response, $args)
    {
        $idPedido = $args['id'];
        $parametros = $request->getParsedBody();

        $tiempoEstimado = $parametros['tiempoEstimado'];

        $ruta = $request->getUri()->getPath();
        $tipoProducto = '';

        if (strpos($ruta, '/productosPedidos/prepararTrago/') !== false) {
            $tipoProducto = 'trago';
        } elseif (strpos($ruta, '/productosPedidos/prepararComida/') !== false) {
            $tipoProducto = 'comida';
        } elseif (strpos($ruta, '/productosPedidos/prepararCerveza/') !== false) {
            $tipoProducto = 'cerveza';
        } else {
            $mensaje = ["mensaje" => "Tipo de producto no válido."];
            $response->getBody()->write(json_encode($mensaje));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $producto = ProductosPedidos::ObtenerProductosPorTipoPendiente($tipoProducto);

        $productoEncontrado = false;
        if ($producto) {
            foreach ($producto as $item) {
                if ($item['id'] == $idPedido) {
                    $productoEncontrado = true;
                    break;
                }
            }
        }

        if ($productoEncontrado) {
            $preparandoProducto = ProductosPedidos::PrepararProducto($idPedido, $tiempoEstimado);

            if ($preparandoProducto) {
                $mensaje = ["mensaje" => "El estado del pedido $idPedido se cambió a 'en preparación'"];
                $response->getBody()->write(json_encode($mensaje));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $mensaje = ["mensaje" => "No se encontró un producto con el ID $idPedido o no está en estado 'pendiente' del tipo $tipoProducto"];
        $response->getBody()->write(json_encode($mensaje));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    public static function ListoParaServir($request, $response, $args)
    {
        $idPedido = $args['id'];

        $ruta = $request->getUri()->getPath();
        $tipoProducto = '';

        if (strpos($ruta, '/productosPedidos/listoParaServirTrago/') !== false) {
            $tipoProducto = 'trago';
        } elseif (strpos($ruta, '/productosPedidos/listoParaServirComida/') !== false) {
            $tipoProducto = 'comida';
        } elseif (strpos($ruta, '/productosPedidos/listoParaServirCerveza/') !== false) {
            $tipoProducto = 'cerveza';
        } else {
            $mensaje = ["mensaje" => "Tipo de producto no válido."];
            $response->getBody()->write(json_encode($mensaje));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $producto = ProductosPedidos::ObtenerProductosPorTipoPendiente($tipoProducto);

        $productoEncontrado = false;
        if ($producto) {
            foreach ($producto as $item) {
                if ($item['id'] == $idPedido) {
                    $productoEncontrado = true;
                    break;
                }
            }
        }

        if ($productoEncontrado) {
            $listoParaServir = ProductosPedidos::ListoParaServir($idPedido);

            if ($listoParaServir) {
                $mensaje = ["mensaje" => "El estado del pedido $idPedido se cambió a 'listo para servir'"];
                $response->getBody()->write(json_encode($mensaje));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        }

        $mensaje = ["mensaje" => "No se encontró un producto con el ID $idPedido o no está en estado 'en preparacion' del tipo $tipoProducto"];
        $response->getBody()->write(json_encode($mensaje));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

}

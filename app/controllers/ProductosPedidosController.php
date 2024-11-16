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
        $productos = $estado === 'pendiente'
            ? ProductosPedidos::ObtenerProductosPorTipoPendiente($tipo) 
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
        return self::ObtenerProductosGenerico($request, $response, 'comida');
    }

    public static function ObtenerProductosPorComidaPendiente($request, $response, $args)
    {        
        return self::ObtenerProductosGenerico($request, $response, 'comida', 'pendiente');
    }

    public static function ObtenerProductosPorTrago($request, $response, $args)
    {
        return self::ObtenerProductosGenerico($request, $response, 'trago');
    }

    public static function ObtenerProductosPorTragoPendiente($request, $response, $args)
    {
        return self::ObtenerProductosGenerico($request, $response, 'trago', 'pendiente');
    }

    public static function ObtenerProductosPorCerveza($request, $response, $args)
    {
        return self::ObtenerProductosGenerico($request, $response, 'cerveza');
    }

    public static function ObtenerProductosPorCervezaPendiente($request, $response, $args)
    {
        return self::ObtenerProductosGenerico($request, $response, 'cerveza', 'pendiente');
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

    
}

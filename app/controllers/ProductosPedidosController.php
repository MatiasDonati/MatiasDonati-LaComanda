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

}

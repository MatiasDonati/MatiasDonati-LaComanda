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

    public static function ObtenerProductosPorComida($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipo('comida');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo comida"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }
    public static function ObtenerProductosPorComidaPendiente($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipoPendiente('comida');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo comida"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    
    public static function ObtenerProductosPorTrago($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipo('trago');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo tragos"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }
    public static function ObtenerProductosPorTragoPendiente($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipoPendiente('trago');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo tragos"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public static function ObtenerProductosPorCerveza($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipo('cerveza');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo cerveza"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }
    public static function ObtenerProductosPorCervezaPendiente($request, $response, $args)
    {
        $productos = ProductosPedidos::ObtenerProductosPorTipoPendiente('cerveza');
        
        if ($productos) {
            $response->getBody()->write(json_encode($productos));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se encontraron productos de tipo cerveza"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }
}

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


        // Aca dependiendo la Ruta va a ser el tipo de prod y cada ruta si MW !
        // Aca dependiendo la Ruta va a ser el tipo de prod y cada ruta si MW !
        // Aca dependiendo la Ruta va a ser el tipo de prod y cada ruta si MW !
        // Aca dependiendo la Ruta va a ser el tipo de prod y cada ruta si MW !
        // Aca dependiendo la Ruta va a ser el tipo de prod y cada ruta si MW !

        // Agregarle tiempo estimado cuando se pone "en preparacion"
        // Agregarle tiempo estimado cuando se pone "en preparacion"
        // Agregarle tiempo estimado cuando se pone "en preparacion"
        // Agregarle tiempo estimado cuando se pone "en preparacion"
        // Agregarle tiempo estimado cuando se pone "en preparacion"

        // Habria que ponero en la tabla "tiempoEstimado y en el modelo y ver en todos los lados q arreglar LRPM...
        // Habria que ponero en la tabla "tiempoEstimado y en el modelo y ver en todos los lados q arreglar LRPM...
        // Habria que ponero en la tabla "tiempoEstimado y en el modelo y ver en todos los lados q arreglar LRPM...
        // Habria que ponero en la tabla "tiempoEstimado y en el modelo y ver en todos los lados q arreglar LRPM...





        $tipoProducto = 'trago';
    
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
            $preparandoProducto = ProductosPedidos::PrepararProducto($idPedido);
    
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

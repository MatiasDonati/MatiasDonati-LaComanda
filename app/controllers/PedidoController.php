<?php

require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';
require_once './models/ProductosPedidos.php';

class PedidoController implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        // $parametros = $request->getParsedBody();
        $cliente = $array['cliente'];
        $mesaId = $array['mesaId'];
        $tiempoEstimado = $array['tiempoEstimado'];
        $fecha = date("Y-m-d");
        $precio = $array['precio'];
        
        $pedido = new Pedido();
        $pedido->mesaId = $mesaId;
        $pedido->tiempoEstimado = $tiempoEstimado;
        $pedido->fecha = $fecha;
        $pedido->precio = $precio;
        $pedido->cliente = $cliente; 
        
        // $pedido->estado = 'pendiente';

        $pedido->crearPedido();

        $productos = $array['productos'];

        foreach($productos as $idProducto){

            $productoPedido = new ProductosPedidos();
            $productoPedido->numeroDePedido = $pedido->numeroDePedido;
            $productoPedido->productoId = $idProducto;
            $productoPedido->crearProductosPedidos();
            // var_dump($productoPedido->productoId); 
        }
    
        $payload = json_encode(array("mensaje" => "Pedido creado con éxito"));
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    
    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = Pedido::obtenerPedido($id);
        
        if (!$pedido) {
            return $response->withStatus(404)->write(json_encode(['error' => 'Pedido no encontrado']));
        }

        $numeroDePedido = $pedido->numeroDePedido;
        $productos = ProductosPedidos::ObtenerProductosPorPedido($numeroDePedido);
    
        $payload = [
            'pedido' => $pedido,
            'productos' => $productos 
        ];
        
        $response->getBody()->write(json_encode($payload));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
    

public function TraerTodos($request, $response, $args)
{

    $pedidos = Pedido::obtenerTodos();

    $pedidosConProductos = [];

    foreach ($pedidos as $pedido) {
        $numeroDePedido = $pedido->numeroDePedido;

        $productos = ProductosPedidos::ObtenerProductosPorPedido($numeroDePedido);

        $pedidosConProductos[] = [
            'pedido' => $pedido,
            'productos' => $productos
        ];
    }


    $response->getBody()->write(json_encode($pedidosConProductos));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
}


    public function ModificarUno($request, $response, $args)
    {

        // VER ACA QUE ESTOY TENIENDO ALGUN QUILOMBO
        // VER ACA QUE ESTOY TENIENDO ALGUN QUILOMBO
        // VER ACA QUE ESTOY TENIENDO ALGUN QUILOMBO

        // VER SI NO ES ALGO QUE CAMBIO EN LA BASE DE DATOS
        // VER SI NO ES ALGO QUE CAMBIO EN LA BASE DE DATOS
        // VER SI NO ES ALGO QUE CAMBIO EN LA BASE DE DATOS


        // VER SI POR JSON RAW O getParsedBody();

        $parametros = $request->getParsedBody();
        $id = $args['id'];

        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        echo $array['pepe'];
        $estado = $array['estado'];
        echo"hola";
    
        $resultado = Pedido::modificarPedido($id, $estado);
    
        if ($resultado) {
            $response->getBody()->write(json_encode(array("mensaje" => "Pedido modificado con éxito")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(array("mensaje" => "No se pudo modificar el pedido")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
    

    public function BorrarUno($request, $response, $args)
    {
        $idPedido = $args['id'];
        $resultado = Pedido::borrarPedido($idPedido); 

        echo $resultado;
        
        if ($resultado) {
            $response->getBody()->write(json_encode(array("mensaje" => "Pedido Borrado con éxito")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(array("mensaje" => "No se pudo Borrar el pedido")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
}

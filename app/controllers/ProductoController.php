<?php

require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
  public function CargarUno($request, $response, $args)
  {
      $parametros = $request->getParsedBody();

      $nombre = $parametros['nombre'];
      $tipo = $parametros['tipo'];
      $precio = $parametros['precio'];
      $numeroDePedido = $parametros['numeroDePedido'];

      $producto = new Producto();
      $producto->nombre = $nombre;
      $producto->tipo = $tipo;
      $producto->precio = $precio;
      $producto->numeroDePedido = $numeroDePedido;
      $producto->crearProducto();

      $payload = json_encode(array("mensaje" => "Producto creado con exito"));

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
  }


    public function TraerUno($request, $response, $args)
    {
        $nombre = $args['nombre'];
        $producto = Producto::obtenerProducto($nombre);
        $payload = json_encode($producto);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {

        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $nombre = $parametros['nombre'];
        $tipo = $parametros['tipo'];
        $precio = $parametros['precio'];
        $numeroDePedido = $parametros['numeroDePedido'];
    
        Producto::modificarProducto($id, $nombre, $tipo, $precio, $numeroDePedido);
    
        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function BorrarUno($request, $response, $args)
    {
        $productoId = $args['id'];
        Producto::borrarProducto($productoId);
    
        $payload = json_encode(array("mensaje" => "Producto borrado con exito"));
    
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    

}

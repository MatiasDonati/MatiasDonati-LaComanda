<?php

include_once(__DIR__ . '/../db/AccesoDatos.php');

class ProductosPedidos
{
    public $id;
    public $numeroDePedido;
    public $productoId;


    public $empleadoAcargoId; 
    // Este va a ser un usuario, dependiento del producto sera #bartender  #cervecero, #cocinero.
    // por lo que sera una clave foranea del id del usario.

    // Ver si tiempo estimado y tiempo final es por pedido o por producto.
    // Ver si tiempo estimado y tiempo final es por pedido o por producto.

    public function crearProductosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productosPedidos (numeroDePedido, productoId) VALUES (:numeroDePedido, :productoId)");
        $consulta->bindValue(':numeroDePedido', $this->numeroDePedido, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $this->productoId, PDO::PARAM_INT);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function TraerTodosLosProductosPedidos()
    {
        $objetoAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDato->prepararConsulta("SELECT * FROM productosPedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "ProductosPedidos");
    }

    public static function ObtenerProductosPorPedido($numeroDePedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productosPedidos WHERE numeroDePedido = :numeroDePedido");
        $consulta->bindValue(':numeroDePedido', $numeroDePedido, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'ProductosPedidos');
    }
}

<?php

include_once(__DIR__ . '/../db/AccesoDatos.php');

class ProductosPedidos
{
    public $id;
    public $numeroDePedido;
    public $productoId;

    public $precio;
    public $empleadoACargo; 
    public $estado = 'preparacion';
    public $timpoInicial;
    public $timpoFinal = null;

    public function crearProductosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productosPedidos (numeroDePedido, productoId, empleadoACargo, precio, estado, timpoInicial, timpoFinal) VALUES (:numeroDePedido, :productoId, :empleadoACargo, :precio, :estado, :timpoInicial, :timpoFinal)"
        );
        
        $consulta->bindValue(':numeroDePedido', $this->numeroDePedido, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $this->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':empleadoACargo', $this->empleadoACargo, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':timpoInicial', date("Y-m-d H:i:s"), PDO::PARAM_STR); // FechaAhora
        $consulta->bindValue(':timpoFinal', $this->timpoFinal, PDO::PARAM_NULL);
    
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

    public static function ObtenerUsuariosPorTipoDePedido($tipoDeProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $rol = '';
        switch ($tipoDeProducto) {
            case 'trago':
                $rol = 'bartender';
                break;
            case 'cerveza':
                $rol = 'cervecero';
                break;
            case 'comida':
                $rol = 'cocinero';
                break;
            default:
                return null;
        }
    
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE rol = :rol ORDER BY RAND() LIMIT 1");
        $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);
        $consulta->execute();
    
        return $consulta->fetchObject('Usuario');
    }
    
}

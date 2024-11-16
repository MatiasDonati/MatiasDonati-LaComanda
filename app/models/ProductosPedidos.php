<?php

include_once(__DIR__ . '/../db/AccesoDatos.php');

class ProductosPedidos
{
    public $id;
    public $numeroDePedido;
    public $productoId;

    public $precio;
    public $empleadoACargo; 
    public $estado = 'pendiente';
    public $tiempoInicial;

    public $tiempoFinal = null;

    public $tiempoEstimado = null;


    public function crearProductosPedidos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productosPedidos (numeroDePedido, productoId, empleadoACargo, precio, estado, tiempoInicial, tiempoFinal, tiempoEstimado) VALUES (:numeroDePedido, :productoId, :empleadoACargo, :precio, :estado, :tiempoInicial, :tiempoFinal, :tiempoEstimado)"
        );
        
        $consulta->bindValue(':numeroDePedido', $this->numeroDePedido, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $this->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':empleadoACargo', $this->empleadoACargo, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoInicial', date("Y-m-d H:i:s"), PDO::PARAM_STR); //Ahora

        $consulta->bindValue(':tiempoFinal', $this->tiempoFinal, PDO::PARAM_NULL);
        $consulta->bindValue(':tiempoEstimado', $this->tiempoEstimado, PDO::PARAM_NULL);
    
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


    public static function ObtenerProductosPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM productosPedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    

        return $consulta->fetch(PDO::FETCH_OBJ);
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



    public static function ObtenerProductosPorTipo($tipoDeProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta("
            SELECT pp.*, p.tipo
            FROM productosPedidos pp
            JOIN productos p ON pp.productoId = p.id
            WHERE p.tipo = :tipoDeProducto
        ");
        
        $consulta->bindValue(':tipoDeProducto', $tipoDeProducto, PDO::PARAM_STR);
        
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    
 // ObtenerProductosPorTipoPendiente y ObtenerProductosEnPreparacion Me pa q no van mas 
 // ObtenerProductosPorTipoPendiente y ObtenerProductosEnPreparacion Me pa q no van mas 
 // ObtenerProductosPorTipoPendiente y ObtenerProductosEnPreparacion Me pa q no van mas 
 // ObtenerProductosPorTipoPendiente y ObtenerProductosEnPreparacion Me pa q no van mas 

    public static function ObtenerProductosPorTipoPendiente($tipoDeProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(
            "SELECT pp.*, p.tipo
            FROM productosPedidos pp
            JOIN productos p ON pp.productoId = p.id
            WHERE p.tipo = :tipoDeProducto AND pp.estado = 'pendiente'"
        );
        
        $consulta->bindValue(':tipoDeProducto', $tipoDeProducto, PDO::PARAM_STR);
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($resultado)) {
            return null;
        }
    
        return $resultado;
    }

    public static function ObtenerProductosEnPreparacion($tipoDeProducto)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(
            "SELECT pp.*, p.tipo
            FROM productosPedidos pp
            JOIN productos p ON pp.productoId = p.id
            WHERE p.tipo = :tipoDeProducto AND pp.estado = 'en preparacion'"
        );
        
        $consulta->bindValue(':tipoDeProducto', $tipoDeProducto, PDO::PARAM_STR);
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        if (empty($resultado)) {
            return null;
        }
    
        return $resultado;

    }

    public static function ObtenerProductosPorEstadoYTipo($tipoDeProducto, $estado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $consulta = $objAccesoDatos->prepararConsulta(
            "SELECT pp.*, p.tipo
            FROM productosPedidos pp
            JOIN productos p ON pp.productoId = p.id
            WHERE p.tipo = :tipoDeProducto AND pp.estado = :estado"
        );
        
        $consulta->bindValue(':tipoDeProducto', $tipoDeProducto, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        
        $consulta->execute();
        
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    
        return $resultado ?: null;
    }
    



    public static function PrepararProducto($id, $tiempoEstimado)
    {   
        $producto = self::ObtenerProductosPorId($id);
    
        if ($producto && $producto->estado === 'pendiente') {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            
            $consultaUpdate = $objAccesoDatos->prepararConsulta(
                "UPDATE productosPedidos SET estado = 'en preparacion', tiempoEstimado = :tiempoEstimado WHERE id = :id"
            );
            $consultaUpdate->bindValue(':id', $id, PDO::PARAM_INT);
            $consultaUpdate->bindValue(':tiempoEstimado', $tiempoEstimado, PDO::PARAM_INT);
            $consultaUpdate->execute();
    
            return true;
        } else {
            return false;
        }
    }

    public static function ListoParaServir($id)
    {
        $producto = self::ObtenerProductosPorId($id);
    
        if ($producto && $producto->estado === 'en preparacion') {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            
            $consultaUpdate = $objAccesoDatos->prepararConsulta(
                "UPDATE productosPedidos SET estado = 'listo para servir' WHERE id = :id"
            );
            $consultaUpdate->bindValue(':id', $id, PDO::PARAM_INT);
            $consultaUpdate->execute();
    
            return true;
        } else {
            return false;
        }

    }

    public static function TraerProductosDeUnPedido($numeroDePedido)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
    
        $consulta = $objAccesoDatos->prepararConsulta(
            "SELECT * FROM productosPedidos WHERE numeroDePedido = :numeroDePedido"
        );
    
        $consulta->bindValue(':numeroDePedido', $numeroDePedido, PDO::PARAM_STR);
    
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    


}

<?php

class Pedido
{
    // Quien hizo el pedido ? no importa quien, importa quien tenga el numerodePedido?

    // un atributo que sea un array de productos ??
    // un atributo que sea un array de productos ??

    // Agregar nombre del Cliente
    // Agregar nombre del Cliente
    // Agregar Mozo - q es un usuyario. clave foranea.
    // Agregar Mozo - q es un usuyario. clave foranea con usuario "mozo"

    public $id;
    public $mesaId;  //codigo de identificación o Id
    public $numeroDePedido;
    public $tiempoEstimado;
    public $estado; 
    public $foto;
    public $precio;
    public $fecha;
    
    // Generar esta columna en la tabla q sea null.
    // public $tiempoFinal;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        $this->numeroDePedido = self::generarCodigoUnico();

        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (mesaId, numeroDePedido, precio, fecha, tiempoEstimado, estado)
         VALUES (:mesaId, :numeroDePedido, :precio, :fecha,:tiempoEstimado, :estado)");
        $consulta->bindValue(':mesaId', $this->mesaId, PDO::PARAM_INT);
        $consulta->bindValue(':numeroDePedido', $this->numeroDePedido, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':tiempoEstimado', $this->tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado ?? 'pendiente', PDO::PARAM_STR);
        
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, mesaId, numeroDePedido, precio, fecha, estado FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, mesaId, numeroDePedido, precio, fecha, estado FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($id, $estado)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->rowCount() > 0;
    }

    public static function borrarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime();  // Fecha actual
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fecha->format('Y-m-d H:i:s'));
        $consulta->execute();

        return $consulta->rowCount();
    }

    public static function generarCodigoUnico()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        do {
            $codigo = self::generarCodigoAlfanumerico(5);
            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as count FROM pedidos WHERE numeroDePedido = :codigo");
            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $consulta->execute();
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
        } while ($resultado['count'] > 0); 

        return $codigo;
    }

    private static function generarCodigoAlfanumerico($longitud)
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $codigo = '';
        
        for ($i = 0; $i < $longitud; $i++) {
            $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        
        return $codigo;
    }
}

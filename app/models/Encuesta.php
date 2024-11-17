<?php

include_once(__DIR__ . '/../db/AccesoDatos.php');
class Encuesta
{
    
	public $id;
	public $numeroDePedido;
	public $puntuacionMozo;
	public $puntuacionRestaurante;
	public $puntuacionMesa;
    public $puntuacionCocinero;
    public $comentarios;
    public $fechaCreacion;


    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuestas (numeroDePedido, puntuacionMozo, puntuacionRestaurante, puntuacionMesa,puntuacionCocinero,comentarios)
         VALUES (:numeroDePedido, :puntuacionMozo, :puntuacionRestaurante,:puntuacionMesa,:puntuacionCocinero,:comentarios)");
        $consulta->bindValue(':numeroDePedido', $this->numeroDePedido, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMozo', $this->puntuacionMozo, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionRestaurante', $this->puntuacionRestaurante, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionMesa', $this->puntuacionMesa, PDO::PARAM_INT);
        $consulta->bindValue(':puntuacionCocinero', $this->puntuacionCocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentarios', $this->comentarios, PDO::PARAM_STR);
        

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }
    public static function TraerTodasLasEncuestas()
    {
        $objetoAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objetoAccesoDato->prepararConsulta("select * from encuestas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Encuesta");
    }


    public static function obtenerEncuentaId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM encuestas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Encuesta');
    }


}
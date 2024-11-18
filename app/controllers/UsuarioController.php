<?php

require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';

class UsuarioController extends Usuario implements IApiUsable
{

    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $rol = $parametros['rol'];
        
        $usr = new Usuario();
        $usr->usuario = $usuario;
        $usr->clave = $clave;
        $usr->rol = $rol;
        $idUsuario = $usr->crearUsuario();
        
        $this->registrarLog($idUsuario);
        
        $payload = json_encode(array("mensaje" => "Usuario creado con éxito"));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function TraerUno($request, $response, $args)
    {
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
    
        $id = $args['id'];
        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];
        $rol = $parametros['rol'];
    
        Usuario::modificarUsuario($id, $usuario, $clave, $rol);
    
        $payload = json_encode(array("mensaje" => "Usuario modificado con éxito. Ahora se llama '$usuario' y su rol es '$rol'"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $usuarioId = $args['id'];
        Usuario::borrarUsuario($usuarioId);

        $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public static function obtenerIngresos($request, $response)
    {
      $parametros = $request->getQueryParams();
      $objAccesoDatos = AccesoDatos::obtenerInstancia();

      if(isset($parametros['fecha']) && isset($parametros['fecha2']))
      {
        $consulta = $objAccesoDatos->PrepararConsulta("SELECT u.usuario, l.timestamp FROM usuariosLogs l JOIN usuarios u ON l.idUsuario = u.id 
        WHERE DATE(l.timestamp) BETWEEN :fecha AND :fecha2 
        ORDER BY l.timestamp DESC");

        $consulta->bindParam(':fecha', $parametros['fecha']);
        $consulta->bindParam(':fecha2', $parametros['fecha2']);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($resultado));

      }else if(isset($parametros['fecha'])){

        $consulta = $objAccesoDatos->PrepararConsulta("SELECT u.usuario, l.timestamp FROM usuariosLogs l JOIN usuarios u ON l.idUsuario = u.id
            WHERE DATE(l.timestamp) = :fecha
            ORDER BY l.timestamp DESC");
        $consulta->bindParam(':fecha', $parametros['fecha']);
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $response->getBody()->write(json_encode($resultado));

      }else{
          $mensaje = "Faltan campos";
          $payload = json_encode(array("mensaje" => $mensaje));
          $response->getBody()->write($payload);
      }
      return $response->withHeader('Content-Type', 'application/json');
    }

    public static function OperacionesPorSector($request, $response)
    {
      $parametros = $request->getQueryParams();
      $objAccesoDatos = AccesoDatos::obtenerInstancia();

      if(isset($parametros['fecha']) && isset($parametros['fecha2']))
      {
        $consulta = $objAccesoDatos->PrepararConsulta("SELECT p.tipo AS sector, pp.responsable, COUNT(*) AS num_operaciones
          FROM pedidos_productos pp
          JOIN productos p ON pp.id_producto = p.id
          JOIN pedidos ped ON pp.id_pedido = ped.id
          WHERE ped.fecha BETWEEN :fecha AND :fecha2
          GROUP BY pp.responsable
          ORDER BY num_operaciones DESC");
          $consulta->bindParam(':fecha', $parametros['fecha']);
          $consulta->bindParam(':fecha2', $parametros['fecha2']);
          $consulta->execute();
          $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
          $response->getBody()->write(json_encode($resultado));

        }else if(isset($parametros['fecha'])){

          $consulta = $objAccesoDatos->PrepararConsulta("SELECT p.tipo AS sector, pp.responsable, COUNT(*) AS num_operaciones
          FROM pedidos_productos pp
          JOIN productos p ON pp.id_producto = p.id
          JOIN pedidos ped ON pp.id_pedido = ped.id
          WHERE ped.fecha = :fecha
          GROUP BY p.tipo
          ORDER BY num_operaciones DESC");
          $consulta->bindParam(':fecha', $parametros['fecha']);
          $consulta->execute();
          $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
          $response->getBody()->write(json_encode($resultado));

        }else{
            $mensaje = "Faltan campos";
            $payload = json_encode(array("mensaje" => $mensaje));
            $response->getBody()->write($payload);
        }

        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function suspenderUsuario($request, $response, $args)
    {
        $usuarioId = $args['id']; 
        Usuario::suspenderUsuarioPorId($usuarioId);
    
        $payload = json_encode(array("mensaje" => "Usuario suspendido con éxito"));
    
        $response->getBody()->write($payload);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    

}

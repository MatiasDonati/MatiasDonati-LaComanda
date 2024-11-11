<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estado = $parametros['estado'];
        $codigoDeIdentificacion = Mesa::generarCodigoUnico();
        $mesa = new Mesa();
        $mesa->estado = $estado;
        $mesa->codigoDeIdentificacion = $codigoDeIdentificacion;
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $mesa = Mesa::obtenerMesa($id);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesa" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $estado = $parametros['estado'];
        $codigoDeIdentificacion = $parametros['codigoDeIdentificacion']; 

        Mesa::modificarMesa($id, $codigoDeIdentificacion, $estado);

        $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function BorrarUno($request, $response, $args)
    {
        $mesaId = $args['id'];
        Mesa::borrarMesa($mesaId);
    
        $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function SubirCsv($request, $response)
    {
      if (Mesa::SubirMesaCsv()){
        $payload = json_encode(array("mensaje" => "Los datos del archivo se subieron correctamente!"));
      }else{
        $payload = json_encode(array("mensaje" => "Hubo un problema al subir el archivo."));

      }

      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public static function DescargarCsv($request, $response)
    {
      $request->getParsedBody();

      Mesa::DescargaDbCsv("db/descargas/mesas.csv");
      $rutaCsv = "db/mesas.csv";

      if (file_exists($rutaCsv) && is_readable($rutaCsv)) {
          $response = $response->withHeader('Content-Type', 'application/octet-stream')
                               ->withHeader('Content-Disposition', 'attachment; filename="' . basename($rutaCsv) . '"')
                               ->withHeader('Expires', '0')
                               ->withHeader('Cache-Control', 'must-revalidate')
                               ->withHeader('Pragma', 'public')
                               ->withHeader('Content-Length', filesize($rutaCsv));

          readfile($rutaCsv);
          return $response;

      } else {
        $payload = json_encode(array("mensaje" => "Hubo un problema al descargar el archivo CSV."));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
      }
    
    }
}

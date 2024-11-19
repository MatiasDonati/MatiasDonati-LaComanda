<?php
require_once './models/Mesa.php';
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $estado = 'cerrada';
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
        $estado = $parametros['estado'] ?? null;
        $codigoMesa = $parametros['codigoDeIdentificacion'] ?? null;

        $id = Mesa::obtenerIdMesaConCodigodeIdentificacion($codigoMesa);

        $rolUsuario = $request->getAttribute('rolUsuario');
        $mesaModificada = false;
    
        if ($rolUsuario === 'socio' && $estado === 'cerrada') {
            Mesa::ModificarEstado($id, $estado);
            $mesaModificada = true;
        } elseif ($rolUsuario === 'mozo' && in_array($estado, ['con cliente esperando pedido', 'con cliente comiendo', 'con cliente pagando'])) {
            Mesa::ModificarEstado($id, $estado);
            $mesaModificada = true;
        }
    
        if ($mesaModificada) {
            $payload = json_encode(["mensaje" => "Mesa modificada con éxito"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "El estado y/o quien solicita es erróneo."]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
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

      Mesa::DescargaArchivoCsv("db/descargas/mesas.csv");
      $rutaCsv = "db/descargas/mesas.csv";

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

    public static function ObtenerMesaMasUsada($request, $response, $args)
    {
        $ruta = $request->getUri()->getPath(); 
        $tipo = strpos($ruta, 'menosUsada') !== false ? 'menosUsada' : 'masUsada';
    
        $pedidos = Pedido::obtenerTodos();
        $contadorMesas = [];
    
        foreach ($pedidos as $pedido) {
            if (!empty($pedido->mesaId)) {
                if (!isset($contadorMesas[$pedido->mesaId])) {
                    $contadorMesas[$pedido->mesaId] = 0;
                }
                $contadorMesas[$pedido->mesaId]++;
            }
        }
    
        if (empty($contadorMesas)) {
            $response->getBody()->write(json_encode([
                'mensaje' => 'No se encontraron mesas usadas.',
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        if ($tipo === 'masUsada') {
            $mesaUsada = array_keys($contadorMesas, max($contadorMesas))[0];
            $usos = $contadorMesas[$mesaUsada];
        } else {
            $mesaUsada = array_keys($contadorMesas, min($contadorMesas))[0];
            $usos = $contadorMesas[$mesaUsada];
        }
    
        $response->getBody()->write(json_encode([
            'mesaId' => $mesaUsada,
            'usos' => $usos,
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function MesaQueMasoMenosFacturo($request, $response, $args)
    {
        $pedidos = Pedido::obtenerTodos();
        $facturacionPorMesa = [];
    
        foreach ($pedidos as $pedido) {
            $prodPedidos = ProductosPedidos::ObtenerProductosPorPedido($pedido->numeroDePedido);
            $totalPedido = 0;
    
            foreach ($prodPedidos as $productos) {
                $precioProducto = Producto::obtenerPrecio($productos->productoId);
                $totalPedido += $precioProducto ? (float)$precioProducto : 0;
            }
    
            if (!isset($facturacionPorMesa[$pedido->mesaId])) {
                $facturacionPorMesa[$pedido->mesaId] = 0;
            }
            $facturacionPorMesa[$pedido->mesaId] += $totalPedido;
        }
    
        $uri = $request->getUri()->getPath();
        $esMasFacturo = strpos($uri, 'laQueMasFacturo') !== false;
    
        uasort($facturacionPorMesa, function ($a, $b) {
            return $b <=> $a; 
        });
    
        if ($esMasFacturo) {
            $mesaSeleccionada = array_key_first($facturacionPorMesa);
            $facturacionSeleccionada = $facturacionPorMesa[$mesaSeleccionada];
        } else {
            $mesaSeleccionada = array_key_last($facturacionPorMesa);
            $facturacionSeleccionada = $facturacionPorMesa[$mesaSeleccionada];
        }
        $respuesta = [
            'mensaje' => $esMasFacturo ? 'Mesa que más facturó' : 'Mesa que menos facturó',
            'mesaId' => $mesaSeleccionada,
            'totalFacturado' => $facturacionSeleccionada,
        ];
    
        $response->getBody()->write(json_encode($respuesta));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function FacturacionMesaPorFechas($request, $response, $args)
    {
        
    }


    

}

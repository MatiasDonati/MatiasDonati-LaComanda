<?php

require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';
require_once './models/ProductosPedidos.php';
require_once './models/Producto.php';
include_once(__DIR__ . '/../utils/Archivos.php');


class PedidoController implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

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

        $pedido->crearPedido();

        $productos = $array['productos'];
        foreach($productos as $productoNombre){

            $productoPedido = new ProductosPedidos();
            $productoPedido->numeroDePedido = $pedido->numeroDePedido;
            $productoDetalle = Producto::obtenerProducto($productoNombre);
            $idProducto = $productoDetalle->id;
            $productoPedido->productoId = $idProducto;

            $empleadoACargoRandom = ProductosPedidos::ObtenerUsuariosPorTipoDePedido($productoDetalle->tipo);
            $productoPedido->empleadoACargo = $empleadoACargoRandom->id;
            $productoPedido->precio = $productoDetalle->precio;
            $productoPedido->crearProductosPedidos();

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
    
    public function TraerUnoPorNumeroDePedido($request, $response, $args)
    {
        $numeroDePedido = $args['numeroDePedido'];
        $pedido = Pedido::obtenerPedidoPorNumeroDePedido($numeroDePedido);
    
        if (!$pedido) {
            $response->getBody()->write(json_encode(['error' => 'Pedido no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
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
        $id = $args['id'];

        $json = file_get_contents('php://input');
        $array = json_decode($json, true);

        $estado = $array['estado'];
    
        $resultado = Pedido::modificarPedido($id, $estado);
    
        if ($resultado) {
            $response->getBody()->write(json_encode(array("mensaje" => "Pedido modificado con éxito")));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(array("mensaje" => "No se pudo modificar el pedido o ingreso el mismo estado.")));
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

    public static function TomarFoto($request,  $response)
    {
        $parametros = $request->getParsedBody();
        $numeroDePedido = $parametros['numeroDePedido'];
        $pedido =  Pedido::obtenerPedidoPorNumeroDePedido($numeroDePedido);
        $foto = Archivo::GuardarArchivo("db/fotos/", "{$numeroDePedido}", 'foto', '.jpg');

        if($pedido && $foto){

            echo 'Tenemos pedido, tenemos foto para pedido!';
            echo Pedido::cargarFotoDb($numeroDePedido, $foto) ? 'Se Subio a la base dedatos' : 'Se Subio a la base dedatos';
        }

        $pedido->foto = $foto;
        $payload = json_encode(array("msg" => "Foto agregada con exito"));
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function VerPedidoDeMesa($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $numeroDePedido = $parametros['numeroDePedido'];
        $codigoDeMesa = $parametros['mesa'];
    
        $pedido = Pedido::obtenerPedidoPorNumeroDePedido($numeroDePedido);
    
        if (!$pedido) {
            $response->getBody()->write(json_encode(['error' => 'Pedido no encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    
        if ($pedido->mesaId === $codigoDeMesa) {
    
            $productos = ProductosPedidos::TraerProductosDeUnPedido($numeroDePedido);
    
            $tiemposDeProductos = [];
    
            $fechaAhora = new DateTime('now', new DateTimeZone('America/Argentina/Buenos_Aires'));
    
            foreach ($productos as $producto) {
    
                $tiempoEstimado = new DateInterval("PT" . $producto['tiempoEstimado'] . "M");
    
                $fechaInicial = new DateTime($producto['tiempoInicial'], new DateTimeZone('America/Argentina/Buenos_Aires'));
    
                $diferencia = $fechaAhora->diff($fechaInicial);
                $diferenciaEnMinutos = ($diferencia->h * 60) + $diferencia->i;
    
                $tiempoEstimado->i -= $diferenciaEnMinutos;
    
                if ($tiempoEstimado->i < 0 || $tiempoEstimado->h < 0) {
                    $mensaje = "Listo para servir";
                    $tiemposDeProductos[] = [
                        'producto' => $producto['id'],
                        'diferencia' => "Han pasado " . $diferencia->h . " horas, " . $diferencia->i . " minutos",
                        'nuevoTiempoEstimado' => $mensaje
                    ];
                } else {

                    //ajustar minutos si es negativo
                    //ajustar minutos si es negativo
                    
                    if ($tiempoEstimado->i < 0) {
                        $tiempoEstimado->h -= 1;
                        $tiempoEstimado->i += 60; 
                    }
    
                    $tiemposDeProductos[] = [
                        'producto' => $producto['id'],
                        'diferencia' => "Han pasado " . $diferencia->h . " horas, " . $diferencia->i . " minutos",
                        'nuevoTiempoEstimado' => $tiempoEstimado->format('%H:%I:%S')
                    ];
                }
            }
    

            $response->getBody()->write(json_encode(array(
                "mensaje" => $tiemposDeProductos
            )));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $mensaje = 'No concuerda el pedido con la mesa.';
            $response->getBody()->write(json_encode(array("mensaje" => $mensaje)));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }
    
    public static function VerSiElPedidoEstaCompletoParaServir($request, $response, $args)
    {
        $numeroDePedido = $args['numeroDePedido'];
        $productos = ProductosPedidos::ObtenerProductosPorPedido($numeroDePedido);
    
        $listoParaServir = true;
    
        foreach ($productos as $producto) {
            if ($producto->estado !== "listo para servir") {
                $listoParaServir = false;
                break;
            }
        }
    
        if ($listoParaServir) {
            $payload = json_encode(array("mensaje" => "Todos los productos del pedido $numeroDePedido están listos para servir."));
        } else {
            $payload = json_encode(array("mensaje" => "El pedido $numeroDePedido no está listo para servir. Hay productos 'en preparacion' o 'pendientes'."));
        }
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function TraerPedidoMasOMenosVendido($request, $response, $args)
    {
        $pedidos = Pedido::obtenerTodos();
        $ventas = [];

        foreach ($pedidos as $pedido) {
            $prodPedidos = ProductosPedidos::ObtenerProductosPorPedido($pedido->numeroDePedido);
            $totalPedido = 0;

            foreach ($prodPedidos as $productos) {
                $precioProducto = Producto::obtenerPrecio($productos->productoId);
                $totalPedido += $precioProducto ? (float)$precioProducto : 0;
            }

            $ventas[] = [
                'numeroDePedido' => $pedido->numeroDePedido,
                'total' => $totalPedido
            ];
        }

        $uri = $request->getUri()->getPath();
        $esMasVendido = strpos($uri, 'masVendido') !== false;

        usort($ventas, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        $pedidoSeleccionado = $esMasVendido ? $ventas[0] : end($ventas);

        $respuesta = [
            'mensaje' => $esMasVendido ? 'Pedido con mayor venta' : 'Pedido con menor venta',
            'pedido' => $pedidoSeleccionado
        ];

        $response->getBody()->write(json_encode($respuesta));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function NoSeEntregaronEnTiempoEstupulado($request, $response, $args)
    {
        $pedidos = Pedido::obtenerTodos();
        $resultados = [];
    
        foreach ($pedidos as $pedido) {
            $productosPorPedido = ProductosPedidos::TraerProductosDeUnPedido($pedido->numeroDePedido);
    
            foreach ($productosPorPedido as $producto) {
                if (
                    $producto['tiempoEstimado'] !== null &&
                    $producto['tiempoInicial'] !== null &&
                    $producto['tiempoFinal'] !== null
                ) {
                    $tiempoInicial = new DateTime($producto['tiempoInicial']);
                    $tiempoFinal = new DateTime($producto['tiempoFinal']);
                    $tiempoEstimado = (int)$producto['tiempoEstimado'];
    
                    if ($tiempoFinal < $tiempoInicial) {
                        $tiempoFinal->modify('+1 day');
                    }
                    //segundos a minutios
                    $tiempoQueTardo = ($tiempoFinal->getTimestamp() - $tiempoInicial->getTimestamp()) / 60;
                    $tiempoQueTardo = round($tiempoQueTardo, 2);

                    $resultados[] = [
                        'numeroDePedido' => $pedido->numeroDePedido,
                        'tiempoInicial' => $producto['tiempoInicial'],
                        'tiempoFinal' => $producto['tiempoFinal'],
                        'tiempoEstimadoOriginal' => $producto['tiempoEstimado'],
                        'tiempoQueTardo' => round($tiempoQueTardo, 2),
                        'demora' => $tiempoQueTardo > $tiempoEstimado ? 'Fuera de tiempo' : 'A tiempo',
                    ];
                }
            }
        }
    
        $response->getBody()->write(json_encode($resultados));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function CalcularTiemposPorPedido($request, $response, $args)
    {
        $pedidos = Pedido::obtenerTodos();
        $resultados = [];

        foreach ($pedidos as $pedido) {
            $productosPorPedido = ProductosPedidos::TraerProductosDeUnPedido($pedido->numeroDePedido);

            if (count($productosPorPedido) > 0) {
                $tiempoInicialMasTemprano = null;
                $tiempoFinalMasTarde = null;
                $tiempoEstimadoMayor = 0;

                foreach ($productosPorPedido as $producto) {
                    if (
                        $producto['tiempoEstimado'] !== null &&
                        $producto['tiempoInicial'] !== null &&
                        $producto['tiempoFinal'] !== null
                    ) {
                        $tiempoInicial = new DateTime($producto['tiempoInicial']);
                        $tiempoFinal = new DateTime($producto['tiempoFinal']);
                        $tiempoEstimado = (int)$producto['tiempoEstimado'];

                        if ($tiempoFinal < $tiempoInicial) {
                            $tiempoFinal->modify('+1 day');
                        }

                        if ($tiempoInicialMasTemprano === null || $tiempoInicial < $tiempoInicialMasTemprano) {
                            $tiempoInicialMasTemprano = $tiempoInicial;
                        }

                        if ($tiempoFinalMasTarde === null || $tiempoFinal > $tiempoFinalMasTarde) {
                            $tiempoFinalMasTarde = $tiempoFinal;
                        }

                        if ($tiempoEstimado > $tiempoEstimadoMayor) {
                            $tiempoEstimadoMayor = $tiempoEstimado;
                        }
                    }
                }

                if ($tiempoInicialMasTemprano && $tiempoFinalMasTarde) {
                    $tiempoQueTardo = ($tiempoFinalMasTarde->getTimestamp() - $tiempoInicialMasTemprano->getTimestamp()) / 60;
                    $tiempoQueTardo = round($tiempoQueTardo, 2);

                    $resultados[] = [
                        'numeroDePedido' => $pedido->numeroDePedido,
                        'tiempoInicialMasTemprano' => $tiempoInicialMasTemprano->format('Y-m-d H:i:s'),
                        'tiempoFinalMasTarde' => $tiempoFinalMasTarde->format('Y-m-d H:i:s'),
                        'tiempoEstimadoMayor' => $tiempoEstimadoMayor,
                        'tiempoQueTardo' => $tiempoQueTardo,
                        'demora' => $tiempoQueTardo > $tiempoEstimadoMayor ? 'Fuera de tiempo' : 'A tiempo',
                    ];
                }
            }
        }

        $response->getBody()->write(json_encode($resultados));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function CancelarPedido($request, $response, $args)
    {
        $datos = $request->getParsedBody();
        $numeroDePedido = $datos['numeroDePedido'] ?? null;
    
        if (!$numeroDePedido) {
            $response->getBody()->write(json_encode(["mensaje" => "Numero de pedido no cargado."]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    
        $pedido = Pedido::obtenerPedidoPorNumeroDePedido($numeroDePedido);
    
        if (!$pedido) {
            $response->getBody()->write(json_encode(["mensaje" => "El pedido no existe."]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    
        $resultado = Pedido::cancelarPedido($numeroDePedido);
        $productos = ProductosPedidos::ObtenerProductosPorPedido($numeroDePedido);
        foreach($productos as $producto){
            if($producto){
                echo $producto->id.PHP_EOL;
                ProductosPedidos::CancelarProducto($producto->id);
            }
        }

    
        if ($resultado) {
            $response->getBody()->write(json_encode(["mensaje" => "Pedido cancelado correctamente."]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(["mensaje" => "No se pudo cancelar el pedido o Ya se encuentra cancelado."]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
    
    public static function VerPedidosCancelados($request, $response, $args)
    {
        $prodPedidosCancelados = ProductosPedidos::ObtenerProdPedidosCancelados();

        $response->getBody()->write(json_encode(["productos pedidods cancelados" => $prodPedidosCancelados]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
    



    
    
    





    

}

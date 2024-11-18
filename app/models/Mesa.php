<?php

include_once(__DIR__ . '/../utils/Archivos.php');
require_once __DIR__ . '/../../vendor/autoload.php';



class Mesa
{
    public $id;
    public $codigoDeIdentificacion;
    public $estado;
    public $fechaBaja;

    public function crearMesa()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO mesas (codigoDeIdentificacion, estado, fechaBaja) VALUES (:codigoDeIdentificacion, :estado, :fechaBaja)");
        $consulta->bindValue(':codigoDeIdentificacion', $this->codigoDeIdentificacion, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->bindValue(':fechaBaja', $this->fechaBaja, PDO::PARAM_STR);
    
        $consulta->execute();
    
        return $objAccesoDatos->obtenerUltimoId();
    }
    

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoDeIdentificacion, estado FROM mesas");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Mesa');
    }

    public static function obtenerMesa($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoDeIdentificacion, estado FROM mesas WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function obtenerMesaPorCodigoDeIdentificacion($codigoDeIdentificacion)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoDeIdentificacion, estado FROM mesas WHERE codigoDeIdentificacion = :codigoDeIdentificacion");
        $consulta->bindValue(':codigoDeIdentificacion', $codigoDeIdentificacion, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Mesa');
    }

    public static function modificarMesa($id, $codigoDeIdentificacion, $estado)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET codigoDeIdentificacion = :codigoDeIdentificacion, estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':codigoDeIdentificacion', $codigoDeIdentificacion, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $estado, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function borrarMesa($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE mesas SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime();
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', $fecha->format('Y-m-d H:i:s'));
        $consulta->execute();
    }

    public static function subirMesaCsv()
	{
		$archivo = Archivo::GuardarArchivo("db/subido/", "mesas", 'csv', '.csv');

		if ($archivo != "N/A") {

			$arrayMesas = self::CsvAMesa($archivo);
			foreach ($arrayMesas as $mesa) {
				$mesa->crearMesa();
			}

			return true;
		}

		return false;
	}

    public static function CsvAMesa($rutaArchivo)
    {
        $arrayMesas = [];
        $encabezado = true;
    
        if (($handle = fopen($rutaArchivo, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($encabezado) {
                    if (strtolower($data[0]) == "id") {
                        $encabezado = false;
                        continue;
                    } else {
                        $encabezado = false;
                    }
                }
    
                $mesa = new Mesa();
                $mesa->id = $data[0];
                $mesa->estado = $data[1];
                $mesa->fechaBaja = ($data[2] === 'NULL' || empty($data[2])) ? null : $data[2];
                $mesa->codigoDeIdentificacion = Mesa::generarCodigoUnico();
    
                $arrayMesas[] = $mesa;
            }
            fclose($handle);
        } else {
            echo "No se pudo abrir el archivo CSV.";
        }
    
        return $arrayMesas;
    }

    public static function generarCodigoUnico()
    {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $codigo = '';
        $esUnico = false;

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        
        while (!$esUnico) {
            $codigo = '';
            for ($i = 0; $i < 5; $i++) {
                $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }

            $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) FROM mesas WHERE codigoDeIdentificacion = :codigo");
            $consulta->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $consulta->execute();
            
            $resultado = $consulta->fetchColumn();
            $esUnico = ($resultado == 0) ? true : false;
        }

        return $codigo;
    }

    public static function DescargaArchivoCsv($rutaArchivo)
    {
        $mesas = self::obtenerTodos();
        
        if (empty($mesas)) {
            return false;
        }
    
        $directorio = dirname($rutaArchivo);
        
        if (!is_dir($directorio)) {
            mkdir($directorio, 0777, true);
        }
    
        $archivo = fopen($rutaArchivo, 'w');
        
        fputcsv($archivo, ['id', 'estado', 'fechaBaja', 'codigoDeIdentificacion']);
    
        foreach ($mesas as $mesa) {
            fputcsv($archivo, [
                (int)$mesa->id, 
                $mesa->estado, 
                $mesa->fechaBaja, 
                $mesa->codigoDeIdentificacion
            ]);
        }
    
        fclose($archivo);
    
        return true;
    }

    public function generarPDF($request, $response, $args)
    {
        $pdf = new TCPDF();
    
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('La Comanda - Matias Donati');
        $pdf->SetTitle('Reporte de Mesas');
        $pdf->SetHeaderData('', 0, 'La Comanda', 'Reporte de Mesas', array(0,64,255), array(0,64,128));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
    
        $pdf->AddPage();
    
        $rutaLogo = './db/LogoRestaurante.png';
        $pdf->Image($rutaLogo, 170, 5, 30, 30, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $pdf->Ln(15); //salto de linea

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM mesas");
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
    

        $html = '<h1>Reporte de Mesas</h1>';
        foreach ($resultados as $fila) {
            $fila['fechaBaja'] === null ? $fila['fechaBaja'] = 'Se encuentra activa' : $fila['fechaBaja'];
            $html .= '<p>ID: ' . $fila['id'] . '</p>';
            $html .= '<p>Estado: ' . $fila['estado'] . '</p>';
            $html .= '<p>Fecha de Baja: ' . $fila['fechaBaja'] . '</p>';
            $html .= '<p>Código de Identificación: ' . $fila['codigoDeIdentificacion'] . '</p>';
            $html .= '<hr>';
        }
    
        $pdf->writeHTML($html, true, false, true, false, '');
    
        $pdf->Output('reporte_mesas.pdf', 'D');
    
        return $response->withHeader('Content-Type', 'application/pdf');
    }
    
}

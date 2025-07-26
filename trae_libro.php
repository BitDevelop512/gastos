<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$libro = $_POST['libro'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$unidad = $_POST['unidad'];
	$cuenta = $_POST['cuenta'];
	// Ruta de archivos PDF
	$carpeta = $ruta_local."\\fpdf\\pdf\\Libros";
	if(!file_exists($carpeta))
	{
		mkdir ($carpeta);
	}
	$carpeta1 = $carpeta."\\".$ano;
	if(!file_exists($carpeta1))
	{
		mkdir ($carpeta1);
	}
	// Libros
	switch ($libro)
	{
		case '1':
			$archivo = "AuxBan_".trim($sig_usuario)."_".$periodo."_".$ano."_".$cuenta.".pdf";
			break;
		case '2':
			$archivo = "ConEje_".trim($sig_usuario)."_".$periodo."_".$ano."_".$cuenta.".pdf";
			break;
		case '3':
			$archivo = "DetCom_".trim($sig_usuario)."_".$periodo."_".$ano."_".$cuenta.".pdf";
			break;
		case '4':
			$archivo = "ConEro_".trim($sig_usuario)."_".$unidad."_".$periodo."_".$ano.".pdf";
			break;
		default:
			break;
	}
	$ruta = "fpdf/pdf/Libros/".$ano."/".$archivo;
	if (file_exists($ruta))
	{
		$existe = "1";
	}
	else
	{
		$existe = "0";
	}
	// Rutas configuradas
 	$pregunta = "SELECT url FROM cx_ctr_par";
 	$sql = odbc_exec($conexion, $pregunta);
 	$url = trim(odbc_result($sql,1));
 	$url = $url."fpdf/pdf/Libros/".$ano;
	$salida->archivo = $archivo;
	$salida->carpeta = $url;
	$salida->existe = $existe;
	echo json_encode($salida);
}
// 06/02/2024 - Ajuste descarga libro
?>
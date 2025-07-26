<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$gasto = $_POST['gasto'];
	$datos = $_POST['datos'];
	$datos = iconv("UTF-8", "ISO-8859-1", $datos);
	$unidad = $_POST['unidad'];
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	// Consulta de registro
	$pregunta = "SELECT bienes FROM cx_pla_gad WHERE conse='$conse' AND gasto='$gasto' AND unidad='$unidad' AND ano='$ano'";
	$sql = odbc_exec($conexion, $pregunta);
	$bienes =  trim(odbc_result($sql,1));
	// Actualización de registro
	$graba = "UPDATE cx_pla_gad SET bienes='$datos' WHERE conse='$conse' AND gasto='$gasto' AND unidad='$unidad' AND ano='$ano'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_soporte_partidas.txt", "a");
		fwrite($file, $fec_log." # ".$bienes." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$datos." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
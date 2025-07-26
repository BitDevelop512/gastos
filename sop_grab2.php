<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$hora = $_POST['hora'];
	$fecha0 = $fecha." ".$hora;
	$fecha1 = $_POST['fecha1'];
	$fecha1 = str_replace("/", "", $fecha1);
	$fecha1 = str_replace("-", "", $fecha1);
	$fecha2 = $fecha1." ".$hora;
	$unidad = $_POST['unidad'];
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	// Actualización de registro
	$graba = "UPDATE cx_com_ing SET fecha='$fecha2' WHERE ingreso='$numero' AND unidad='$unidad' AND ano='$ano'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_com_cam)";
		$graba1 = "INSERT INTO cx_com_cam (conse, tipo, comprobante, ano, usuario, unidad, fecha_a, fecha_n) VALUES ($query_c, '1', '$numero', '$ano', '$usu_usuario', '$unidad', '$fecha0', '$fecha2')";
		$sql = odbc_exec($conexion, $graba1);
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_soporte_fechas.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 16/05/2024 - Ajuste actualización de fecha comprobantes de ingreso
// 27/06/2024 - Ajuste actualización de fecha comprobantes de ingreso desde nuevo modulo
?>
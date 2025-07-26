<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$interno = $_POST['interno'];
	$placa = $_POST['placa'];
	// Se consulta placa actual
  $pregunta = "SELECT placa FROM cx_pla_tra WHERE conse='$interno'";
  $sql = odbc_exec($conexion, $pregunta);
  $placa1 = trim(odbc_result($sql,1));
	// Se actualiza nueva placa
	$graba = "UPDATE cx_pla_tra SET placa='$placa' WHERE conse='$interno'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Se crea notificacion
		$mensaje = "<br>SE MODIFICO LA PLACA DEL VEHICULO DE ".$placa1." A ".$placa." POR EL USUARIO ".$usu_usuario.".<br><br>";
	  $query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_notifica)";
		$query = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', 'ING_SIGAR', '1', '$mensaje', 'W', '1')";
  	odbc_exec($conexion, $query);
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_transportes_placa.txt", "a");
		fwrite($file, $fec_log." # ".$placa1." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 21/01/2025 - Ajuste inclusion notificacion cambio de placa
?>
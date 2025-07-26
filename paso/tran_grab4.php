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
	// Actualiza
	$graba = "UPDATE cx_pla_tra SET placa='$placa' WHERE conse='$interno'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_transportes_placa.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
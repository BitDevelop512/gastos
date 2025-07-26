<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$observaciones = trim($_POST['observaciones']);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	// Actualiza
	$graba = "UPDATE cx_reg_rev SET observaciones='$observaciones' WHERE conse='$conse' AND usuario='$usu_usuario'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_revision_observa.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
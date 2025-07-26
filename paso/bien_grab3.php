<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$codigo = $_POST['codigo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	// Actualiza
	$graba = "UPDATE cx_pla_bie SET valor='$valor', valor1='$valor1' WHERE conse='$conse' AND codigo='$codigo'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_bienes_valor.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
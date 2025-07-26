<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$usuario = $_POST['usuario'];
	$login = $_POST['login'];
	$query = "UPDATE cx_usu_web SET usuario='$usuario' WHERE conse='$conse' AND usuario='$login'";
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_usu_cam)";
		$graba = "INSERT INTO cx_usu_cam (conse, usuario, nuevo, autoriza, nombre) VALUES ($query_c, '$login', '$usuario', '$usu_usuario', '$nom_usuario')";
		$sql = odbc_exec($conexion, $graba);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_usu_cam1.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
		fclose($file);
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_usu_cam.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$actu = $_POST['actu'];
	$conse = $_POST['conse'];
	$recurso = trim($_POST['recurso']);
	$recurso = iconv("UTF-8", "ISO-8859-1", $recurso);
	$estado = $_POST['estado'];
	if ($actu == "1")
	{
		$query_c = "(SELECT isnull(max(codigo),0)+1 FROM cx_ctr_rec)";
		$query = "INSERT INTO cx_ctr_rec (codigo, nombre, estado) VALUES ($query_c, '$recurso', '$estado')";
	}
	else
	{
		$query = "UPDATE cx_ctr_rec SET nombre='$recurso', estado='$estado' WHERE codigo='$conse'";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ctr.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	$salida = new stdClass();
	$salida->confirma = $confirma;
	echo json_encode($salida);
}
?>
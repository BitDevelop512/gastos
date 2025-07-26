<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$tipod = $_POST['tipod'];
	$nombre = $_POST['nombre'];
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$valor1 = $_POST['valor1'];
	$valor2 = $_POST['valor2'];
	$tipo = $_POST['tipo'];
	if ($tipo == "0")
	{
		$query_c = "(SELECT isnull(max(codigo),0)+1 FROM cx_ctr_dir)";
		$graba = "INSERT INTO cx_ctr_dir (codigo, nombre, tipo, valor1, valor2) VALUES ($query_c, '$nombre', '$tipod', '$valor1', '$valor2')";
	}
	else
	{
		$graba = "UPDATE cx_ctr_dir SET nombre='$nombre', tipo='$tipod', valor1='$valor1', valor2='$valor2' WHERE codigo='$conse'";
	}
	if (!odbc_exec($conexion, $graba))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ctr_directiva.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
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
	$descripcion = trim($_POST['descripcion']);
	$descripcion = iconv("UTF-8", "ISO-8859-1", $descripcion);
	$tipo = $_POST['tipo'];
	$descarga = $_POST['descarga'];
	if ($actu == "1")
	{
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_ctr_nor");
		$consecu = odbc_result($cur,1);
		$query = "INSERT INTO cx_ctr_nor (conse, nombre, tipo, descarga) VALUES ('$consecu', '$descripcion', '$tipo', '$descarga')";
	}
	else
	{
		$consecu = $conse;
		$query = "UPDATE cx_ctr_nor SET nombre='$descripcion', tipo='$tipo', descarga='$descarga' WHERE conse='$conse'";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ctr_nor.txt", "a");
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
	$salida->salida = $confirma;
	$salida->consecu = $consecu;
	echo json_encode($salida);
}
?>
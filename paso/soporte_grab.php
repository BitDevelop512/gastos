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
	$soporte = trim($_POST['soporte']);
	$soporte = iconv("UTF-8", "ISO-8859-1", $soporte);
	$tipo = $_POST['tipo'];
	if ($actu == "1")
	{
		$query_c = "(SELECT isnull(max(codigo),0)+1 FROM cx_ctr_doc)";
		$query = "INSERT INTO cx_ctr_doc (codigo, nombre, estado) VALUES ($query_c, '$soporte', '$tipo')";
	}
	else
	{
		$query = "UPDATE cx_ctr_doc SET nombre='$soporte', estado='$tipo' WHERE codigo='$conse'";
	}
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
	echo json_encode($salida);
}
?>
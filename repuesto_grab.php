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
	$repuesto = trim($_POST['repuesto']);
	$repuesto = iconv("UTF-8", "ISO-8859-1", $repuesto);
	$medida = $_POST['medida'];
	$tipo = $_POST['tipo'];
	$tipo1 = $_POST['tipo1'];
	if ($actu == "1")
	{
		$query_c = "(SELECT isnull(max(codigo),0)+1 FROM cx_ctr_rep)";
		$query = "INSERT INTO cx_ctr_rep (codigo, nombre, medida, estado, usuario, tipo) VALUES ($query_c, '$repuesto', '$medida', '$tipo', '$usu_usuario', '$tipo1')";
	}
	else
	{
		$query = "UPDATE cx_ctr_rep SET nombre='$repuesto', medida='$medida', estado='$tipo', usuario='$usu_usuario', tipo='$tipo1' WHERE codigo='$conse'";
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
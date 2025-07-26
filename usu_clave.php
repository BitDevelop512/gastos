<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$clave='827ccb0eea8a706c4c34a16891f84e7b';
	$query = "UPDATE cx_usu_web SET clave='$clave', cambio='1' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	// Se verifica el cambio de clave del usuario
	$query1 = "SELECT clave FROM cx_usu_web WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$valida = odbc_result($cur,1);
	if (trim($valida) == trim($clave))
	{
		$consecu = "1";
	}
	else
	{
		$consecu = "0";
	}

	$salida = new stdClass();
	$salida->salida = $consecu;
	echo json_encode($salida);
}
?>
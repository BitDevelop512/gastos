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
	$query = "UPDATE cx_usu_web SET tipo='0', unidad='0', admin='0', firma='', ciudad='' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	// Se verifica el cambio de tipo a 0 para reinicio
	$query1 = "SELECT tipo FROM cx_usu_web WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$consecu = odbc_result($cur,1);

	$salida = new stdClass();
	$salida->salida = $consecu;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	$query = "SELECT unidad, dependencia, unic, tipo FROM cx_org_sub WHERE subdependencia='$unidad'";
	$cur = odbc_exec($conexion, $query);
	$brigada = odbc_result($cur,2);
	$division = odbc_result($cur,1);
	$centralizadora = odbc_result($cur,3);
	$tipouni = odbc_result($cur,4);
	$salida->brigada = $brigada;
	$salida->division = $division;
	$salida->centralizadora = $centralizadora;
	$salida->tipouni = $tipouni;
	echo json_encode($salida);
}
?>
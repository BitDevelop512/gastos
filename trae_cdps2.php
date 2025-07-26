<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$crp = $_POST['crp'];
	$crp1 = $_POST['crp1'];
	$query = "SELECT recurso, rubro, conse1 FROM cx_crp WHERE conse='$crp' AND numero='$crp1'";
	$cur = odbc_exec($conexion, $query);
	$recurso = odbc_result($cur,1);
	$rubro = odbc_result($cur,2);
	$conse = odbc_result($cur,3);
	$query1 = "SELECT numero FROM cx_cdp WHERE conse='$conse'";
	$cur1 = odbc_exec($conexion, $query1);
	$cdp = odbc_result($cur1,1);
	$salida->recurso = $recurso;
	$salida->rubro = $rubro;
	$salida->conse = $conse;
	$salida->cdp = $cdp;
	echo json_encode($salida);
}
?>
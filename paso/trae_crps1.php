<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$crp = $_POST['crp'];
	$query = "SELECT conse1, fecha1, saldo FROM cx_crp WHERE conse='$crp'";
	$cur = odbc_exec($conexion, $query);
	$conse = odbc_result($cur,1);
	$fec_crp = odbc_result($cur,2);
	$sal_crp = odbc_result($cur,3);
	$query1 = "SELECT conse, fecha1, origen, recurso, rubro FROM cx_cdp WHERE conse='$conse'";	
	$cur1 = odbc_exec($conexion, $query1);
	$cdp = odbc_result($cur1,1);
	$fec_cdp = odbc_result($cur1,2);
	$origen = odbc_result($cur1,3);
	$recurso = odbc_result($cur1,4);
	$rubro = odbc_result($cur1,5);
	$salida->fec_crp = $fec_crp;
	$salida->sal_crp = $sal_crp;
	$salida->cdp = $cdp;
	$salida->fec_cdp = $fec_cdp;
	$salida->origen = $origen;
	$salida->recurso = $recurso;
	$salida->rubro = $rubro;
	echo json_encode($salida);
}
?>
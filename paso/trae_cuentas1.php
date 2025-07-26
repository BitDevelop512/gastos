<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$query = "SELECT cuenta, saldo FROM cx_org_sub WHERE subdependencia='$uni_usuario' AND unic='1'";
	$cur = odbc_exec($conexion, $query);
	$cuenta = trim(odbc_result($cur,1));
	$saldo = odbc_result($cur,2);
	if (($uni_usuario == "1") or ($uni_usuario == "2"))
	{
		$query1 = "SELECT conse, nombre, cuenta, saldo FROM cx_ctr_cue WHERE unidad='1'";
	}
	else
	{
		$query1 = "SELECT conse, nombre, cuenta, saldo FROM cx_ctr_cue WHERE 1=2";
	}
	$cur1 = odbc_exec($conexion, $query1);
	$respuesta = array();
	$cursor0 = array();
	$cursor0["codigo"] = "1";
	$cursor0["nombre"] = "GASTOS";
	$cursor0["cuenta"] = $cuenta;
	$cursor0["saldo"] = $saldo;
	$cursor0["saldo1"] = number_format($saldo,2);
	array_push($respuesta, $cursor0);
	$i=0;
	while($i<$row=odbc_fetch_array($cur1))
	{
		$cursor = array();
		$saldo = odbc_result($cur1,4);
		if ($saldo == ".00")
		{
			$saldo = "0.00";
		}
	    $cursor["codigo"] = odbc_result($cur1,1);
	    $cursor["nombre"] = trim(odbc_result($cur1,2));
	    $cursor["cuenta"] = trim(odbc_result($cur1,3));
	    $cursor["saldo"] = $saldo;
	    $cursor["saldo1"] = number_format($saldo,2);
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
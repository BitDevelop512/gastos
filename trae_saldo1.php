<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$query0 = "SELECT * FROM cv_cdp_disc2 WHERE conse='$conse'";
	$cur0 = odbc_exec($conexion, $query0);
	$adiciones = odbc_result($cur0,5);
	if ($adiciones == ".00")
	{
		$adiciones = "0.00";
	}
	$reducciones = odbc_result($cur0,6);
	if ($reducciones == ".00")
	{
		$reducciones = "0.00";
	}
	$query = "SELECT numero FROM cv_crp2 WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query);
	$numero = trim(odbc_result($cur,1));
	$query0 = "SELECT disponible FROM cv_crp2 WHERE numero='$numero'";
	$cur0 = odbc_exec($conexion, $query0);
  	$v_disponible = 0;
  	while($j<$row=odbc_fetch_array($cur0))
  	{
    	$v_valor = odbc_result($cur0,1);
    	$v_valor1 = floatval($v_valor);
    	$v_disponible = $v_disponible+$v_valor1;
  	}
  	$saldo = $v_disponible;
  	$saldo = ($saldo+$adiciones)-$reducciones;
    if ($saldo == ".00")
    {
        $saldo = "0.00";
    }
	// Se traen datos del CDP seleccionado
	$query1 = "SELECT origen,recurso,rubro FROM cx_cdp WHERE conse='$conse'";
	$cur1 = odbc_exec($conexion, $query1);
	$origen = odbc_result($cur1,1);
	$recurso = odbc_result($cur1,2);
	$rubro = odbc_result($cur1,3);
	// Jorge Clavijo - Solicitud correo 08/03/2023
	$query6 = "SELECT ISNULL(SUM(reducciones),0) AS reducciones FROM cv_crp_disc2 WHERE conse1='$conse' AND numero='$numero'";
	$cur6 = odbc_exec($conexion, $query6);
	$reducciones1 = odbc_result($cur6,1);
	$reducciones1 = floatval($reducciones1);
	$saldo = $saldo+$reducciones1;
	// Se cargan datos en el arreglo de salida
	$salida->salida = $saldo;
	$salida->origen = $origen;
	$salida->recurso = $recurso;
	$salida->rubro = $rubro;
	echo json_encode($salida);
}
?>
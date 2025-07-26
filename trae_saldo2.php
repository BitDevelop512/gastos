<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$recurso = $_POST['recurso'];
	$recurso1 = $_POST['recurso1'];
	$ano = $_POST['ano'];
	$query = "SELECT conse FROM cx_cdp WHERE recurso='$recurso1' AND vigencia='$ano'";
	$cur = odbc_exec($conexion, $query);
	$conses = "";
  	while($i<$row=odbc_fetch_array($cur))
  	{
    	$conses .= odbc_result($cur,1).", ";
  	}
  	$conses = substr($conses,0,-2);
	$query1 = "SELECT ISNULL(SUM(saldo),0) AS saldo FROM cv_cdp_disc2 WHERE conse IN ($conses)";
	$cur1 = odbc_exec($conexion, $query1);
	$saldo = odbc_result($cur1,1);
	$query2 = "SELECT valor1 FROM cx_apropia WHERE recurso='$recurso1' AND ano='$ano'";
	$cur2 = odbc_exec($conexion, $query2);
    $valor = odbc_result($cur2,1);
    $valor = floatval($valor);
	$query3 = "SELECT ISNULL(SUM(valor1),0) AS adiciones FROM cx_apro_dis WHERE conse1='$ano' AND recurso='$recurso1' AND tipo='A'";
	$cur3 = odbc_exec($conexion, $query3);
    $adiciones = odbc_result($cur3,1);
    $adiciones = floatval($adiciones);
	$query4 = "SELECT ISNULL(SUM(valor1),0) AS reducciones FROM cx_apro_dis WHERE conse1='$ano' AND recurso='$recurso1' AND tipo='R'";
	$cur4 = odbc_exec($conexion, $query4);
	$reducciones = odbc_result($cur4,1);
	$reducciones = floatval($reducciones);
	$saldo = $valor+($adiciones-$reducciones);
	$query5 = "SELECT ISNULL(SUM(valor1),0) AS suma FROM cx_cdp WHERE recurso='$recurso1' AND vigencia='$ano'";
	$cur5 = odbc_exec($conexion, $query5);
	$suma = odbc_result($cur5,1);
	$suma = floatval($suma);
	$disponible = $saldo-$suma;
	// Jorge Clavijo - Solicitud correo 08/03/2023
	$query6 = "SELECT ISNULL(SUM(reducciones),0) AS reducciones FROM cv_cdp_disc2 WHERE conse IN ($conses)";
	$cur6 = odbc_exec($conexion, $query6);
	$reducciones1 = odbc_result($cur6,1);
	$reducciones1 = floatval($reducciones1);
	$disponible = $disponible+$reducciones1;
	// Se cargan datos en el arreglo de salida
	$salida->saldo = $disponible;
	echo json_encode($salida);
}
?>
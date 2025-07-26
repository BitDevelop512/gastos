<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
    $ano = $_POST['ano'];
    $recurso = $_POST['recurso'];
	$query = "SELECT valor1 FROM cx_apropia WHERE ano='$ano' AND recurso='$recurso'";
	$cur = odbc_exec($conexion, $query);
	$valor = odbc_result($cur,1);
	$valor = floatval($valor);
	$query1 = "SELECT ISNULL(SUM(valor1),0) AS adiciones FROM cx_apro_dis WHERE conse1='$ano' AND recurso='$recurso' AND tipo='A'";
	$cur1 = odbc_exec($conexion, $query1);
	$adiciones = odbc_result($cur1,1);
	$adiciones = floatval($adiciones);
	$query2 = "SELECT ISNULL(SUM(valor1),0) AS reducciones FROM cx_apro_dis WHERE conse1='$ano' AND recurso='$recurso' AND tipo='R'";
	$cur2 = odbc_exec($conexion, $query2);
	$reducciones = odbc_result($cur2,1);
	$reducciones = floatval($reducciones);
	$saldo = $valor+($adiciones-$reducciones);
	// Se calcula el saldo disponible de la vigencia por recurso
	$query3 = "SELECT ISNULL(SUM(valor1),0) AS suma FROM cx_cdp WHERE recurso='$recurso' AND vigencia='$ano'";
	$cur3 = odbc_exec($conexion, $query3);
	$suma = odbc_result($cur3,1);
	$suma = floatval($suma);
	$disponible = $saldo-$suma;
	// Se cargan datos en el arreglo de salida
	$salida->saldo = $saldo;
	$salida->suma = $suma;
	$salida->disponible = $disponible;
	echo json_encode($salida);
}
?>
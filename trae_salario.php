<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$query = "SELECT salario, tarifa1, tarifa2, tarifa3 FROM cx_ctr_ano WHERE ano='$ano'";
	$cur = odbc_exec($conexion, $query);
	$salario = trim(odbc_result($cur,1));
	$salario = floatval($salario);
	$tarifa1 = trim(odbc_result($cur,2));
	$tarifa1 = floatval($tarifa1);
	$tarifa2 = trim(odbc_result($cur,3));
	$tarifa2 = floatval($tarifa2);
	$tarifa3 = trim(odbc_result($cur,4));
	$tarifa3 = floatval($tarifa3);
	$salida = new stdClass();
	$salida->salario = $salario;
	$salida->tarifa1 = $tarifa1;
	$salida->tarifa2 = $tarifa2;
	$salida->tarifa3 = $tarifa3;
	echo json_encode($salida);
}
// 05/12/2024 - Ajuste tarifas planillas
?>
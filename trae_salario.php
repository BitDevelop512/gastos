<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$query = "SELECT salario, tarifa1, tarifa2, tarifa3, tarifa4, tope_slr_ind, tope_slr_max FROM cx_ctr_ano WHERE ano='$ano'";
	$cur = odbc_exec($conexion, $query);
	$salario = trim(odbc_result($cur,1));
	$salario = floatval($salario);
	$tarifa1 = trim(odbc_result($cur,2));
	$tarifa1 = floatval($tarifa1);
	$tarifa2 = trim(odbc_result($cur,3));
	$tarifa2 = floatval($tarifa2);
	$tarifa3 = trim(odbc_result($cur,4));
	$tarifa3 = floatval($tarifa3);
	$tarifa4 = trim(odbc_result($cur,5));
	$tarifa4 = floatval($tarifa4);
	$tope_slr_ind = trim(odbc_result($cur,6));
	$tope_slr_max = trim(odbc_result($cur,7));
	$salida = new stdClass();
	$salida->salario = $salario;
	$salida->tarifa1 = $tarifa1;
	$salida->tarifa2 = $tarifa2;
	$salida->tarifa3 = $tarifa3;
	$salida->tarifa4 = $tarifa4;
	$salida->tope_slr_ind = $tope_slr_ind;
	$salida->tope_slr_max = $tope_slr_max;
	echo json_encode($salida);
}
// 05/12/2024 - Ajuste tarifas planillas
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$query = "SELECT salario FROM cx_ctr_ano WHERE ano='$ano'";
	$cur = odbc_exec($conexion, $query);
	$salario = trim(odbc_result($cur,1));
	$salario = floatval($salario);
	$salida = new stdClass();
	$salida->salario = $salario;
	echo json_encode($salida);
}
?>
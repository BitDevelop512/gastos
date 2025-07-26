<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$material = trim($_POST['material']);
	$material = iconv("UTF-8", "ISO-8859-1", $material);
	$unidad = $_POST['unidad'];
	$valor = trim($_POST['valor']);
	$valor1 = trim($_POST['valor1']);
	$porcen = floatval($_POST['porcen']);
	$directiva = $_POST['directiva'];
	if ($valor1 == "")
	{
		$valor1 = "0.00";
	}
	$query = "UPDATE cx_ctr_mat SET nombre='$material', unidad='$unidad', valor='$valor', valor1='$valor1', porcen='$porcen', directiva='$directiva' WHERE codigo='$conse'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT codigo FROM cx_ctr_mat WHERE codigo='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
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
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(codigo),0)+1 AS conse FROM cx_ctr_mat");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_ctr_mat (codigo, nombre, unidad, valor, valor1, porcen, directiva) VALUES ('$consecu', '$material', '$unidad', '$valor', '$valor1', '$porcen', '$directiva')";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT codigo FROM cx_ctr_mat WHERE codigo='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
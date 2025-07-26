<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$placa = $_POST['placa'];
	$kilometraje = $_POST['kilometraje'];
	$kilometraje = intval($kilometraje);
	$query = "SELECT TOP 1 kilometraje FROM cx_tra_mov WHERE placa='$placa' ORDER BY fecha DESC";
	$cur = odbc_exec($conexion, $query);
	$kilometraje1 = odbc_result($cur,1);
	$kilometraje1 = intval($kilometraje1);
	$kilometraje2 = number_format($kilometraje1,0);
	if ($kilometraje >= $kilometraje1)
	{
		$valida = "1";
	}
	else
	{
		$valida = "0";
	}
	$salida = new stdClass();
	$salida->salida = $valida;
	$salida->kilometraje = $kilometraje2;
	echo json_encode($salida);
}
// 27/10/2023 - Trae kilometraje registrado para validacion en relacion de gastos
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$vigencia = $_POST['vigencia'];
	$recurso = $_POST['recurso'];
	$query = "SELECT disponible FROM cv_cdp2 WHERE ano='$vigencia' AND recurso='$recurso' AND disponible>0";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	if ($total > 0)
	{
		$saldo = odbc_result($cur,1);
	}
	else
	{
		$saldo = "0";
	}
	$salida->salida = $saldo;
	echo json_encode($salida);
}
?>
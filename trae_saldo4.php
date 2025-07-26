<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	if ($tipo == "1")
	{
		$query = "SELECT saldo FROM cv_cdp_disc2 WHERE conse='$valor1' AND numero='$valor'";
	}
	else
	{
		$query = "SELECT saldo FROM cv_crp_disc2 WHERE conse='$valor1' AND numero='$valor'";
	}
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
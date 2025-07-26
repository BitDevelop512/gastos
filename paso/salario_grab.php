<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$salario = $_POST['salario'];
	$tipo = $_POST['tipo'];
	if ($tipo == "0")
	{
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_ctr_ano)";
		$graba = "INSERT INTO cx_ctr_ano (conse, salario, ano) VALUES ($query_c, '$salario', '$ano')";
	}
	else
	{
		$graba = "UPDATE cx_ctr_ano SET salario='$salario' WHERE ano='$ano'";
	}
	if (!odbc_exec($conexion, $graba))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
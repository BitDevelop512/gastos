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
	$tarifa1 = $_POST['tarifa1'];
	$tarifa2 = $_POST['tarifa2'];
	$tarifa3 = $_POST['tarifa3'];
	$tipo = $_POST['tipo'];
	if ($tipo == "0")
	{
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_ctr_ano)";
		$graba = "INSERT INTO cx_ctr_ano (conse, tarifa1, tarifa2, tarifa3, salario, ano) VALUES ($query_c, '$tarifa1', '$tarifa2', '$tarifa3', '$salario', '$ano')";
	}
	else
	{
		$graba = "UPDATE cx_ctr_ano SET tarifa1='$tarifa1', tarifa2='$tarifa2', tarifa3='$tarifa3', salario='$salario' WHERE ano='$ano'";
	}
	if (!odbc_exec($conexion, $graba))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ctr_ano.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 05/12/2024 - Ajuste grabacion valores planilla
?>
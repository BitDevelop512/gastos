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
	$tarifa4 = $_POST['tarifa4'];
	$tope_slr_ind = $_POST['tope_slr_ind'];
	$tope_slr_max = $_POST['tope_slr_max'];
	$tipo = $_POST['tipo'];
	$query = "SELECT tarifa4 FROM cx_ctr_ano WHERE ano='$ano'";
	$cur = odbc_exec($conexion, $query);
	$tarifa_anterior = trim(odbc_result($cur,1));
	if ($tipo == "0")
	{
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_ctr_ano)";
		$graba = "INSERT INTO cx_ctr_ano (conse, tarifa1, tarifa2, tarifa3, salario, ano, tarifa4, tope_slr_ind, tope_slr_max) VALUES ($query_c, '$tarifa1', '$tarifa2', '$tarifa3', '$salario', '$ano', '$tarifa4', '$tope_slr_ind', '$tope_slr_max')";
	}
	else
	{
		$graba = "UPDATE cx_ctr_ano SET tarifa1='$tarifa1', tarifa2='$tarifa2', tarifa3='$tarifa3', salario='$salario', tarifa4='$tarifa4', tope_slr_ind='$tope_slr_ind', tope_slr_max='$tope_slr_max' WHERE ano='$ano'";
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
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ctr_GFM.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".$tarifa_anterior." # ".$tarifa4." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 05/12/2024 - Ajuste grabacion valores planilla
?>
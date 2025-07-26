<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$conse = $_POST['conse'];
	$divisiones = $_POST['divisiones'];
	$brigada = $_POST['brigada'];
	$brigada = iconv("UTF-8", "ISO-8859-1", $brigada);
	if ($tipo == "1")
	{
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(dependencia),0)+1 AS conse FROM cx_org_dep");
		$consecu = odbc_result($cur1,1);
		$query = "INSERT INTO cx_org_dep (unidad, dependencia, nombre) VALUES ('$divisiones', '$consecu', '$brigada')";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT dependencia FROM cx_org_dep WHERE dependencia='$consecu'";
		$cur = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur,1);
	}
	else
	{
		$query = "UPDATE cx_org_dep SET nombre='$brigada', unidad='$divisiones' WHERE dependencia='$conse'";
		$sql = odbc_exec($conexion, $query);
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_brigadas.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
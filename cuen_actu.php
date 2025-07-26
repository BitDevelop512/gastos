<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$cuenta = trim($_POST['cuenta']);
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$banco = $_POST['banco'];
	$saldo = trim($_POST['saldo']);
	$saldo1 = trim($_POST['saldo1']);
	$query = "UPDATE cx_ctr_cue SET nombre='$nombre', cuenta='$cuenta', banco='$banco' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT conse FROM cx_ctr_cue WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_cuentas.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
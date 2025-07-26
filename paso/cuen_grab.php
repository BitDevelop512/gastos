<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$cuenta = trim($_POST['cuenta']);
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$banco = $_POST['banco'];
	$saldo = trim($_POST['saldo']);
	$saldo1 = trim($_POST['saldo1']);
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_ctr_cue");
	$consecu = odbc_result($cur,1);
	$consecu = intval($consecu);
	if ($consecu == "1")
	{
		$consecu = $consecu+1;
	}
	$query = "INSERT INTO cx_ctr_cue (conse, fecha, usuario, unidad, nombre, cuenta, saldo, cheque, banco) VALUES ('$consecu', getdate(), '$usu_usuario', '$uni_usuario', '$nombre', '$cuenta', '$saldo1', '', '$banco')";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT conse FROM cx_ctr_cue WHERE conse='$consecu'";
	$cur1 = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur1,1);
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
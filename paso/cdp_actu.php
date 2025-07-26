<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$cdp = $_POST['cdp'];
	$fecha = $_POST['fecha'];
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_cdp_dis");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_cdp_dis (conse, conse1, fecha, valor, valor1, tipo, usuario, fecha1) VALUES ('$consecu', '$cdp', getdate(), '$valor', '$valor1', '$tipo', '$usu_usuario', '$fecha')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_cdp_dis WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ejecu.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	// Se retornan variables
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
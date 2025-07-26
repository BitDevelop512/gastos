<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$ano = $_POST['ano'];
	$fecha = $_POST['fecha'];
	$rubro = $_POST['rubro'];
	$recurso = $_POST['recurso'];
	$rubro1 = $_POST['rubro1'];
	$recurso1 = $_POST['recurso1'];
	$destinacion = $_POST['destinacion'];
	$destinacion = iconv("UTF-8", "ISO-8859-1", $destinacion);
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_apropia");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_apropia (conse, valor, valor1, ano, usuario, saldo, fecha1, rubro, recurso, destino, rubro1, recurso1) VALUES ('$consecu', '$valor', '$valor1', '$ano', '$usu_usuario', '$valor1', '$fecha', '$rubro', '$recurso', '$destinacion', '$rubro1', '$recurso1')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_apropia WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ejecu.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);

	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
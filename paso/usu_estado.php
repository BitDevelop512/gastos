<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$pregunta = "SELECT estado FROM cx_usu_web WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $pregunta);
	$estado = odbc_result($cur,1);
	if ($estado == "1")
	{
		$n_estado = "2";
	}
	else
	{
		$n_estado = "1";
	}
	$query = "UPDATE cx_usu_web SET estado='$n_estado' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	// Se verifica el cambio de estado del usuario
	$query1 = "SELECT estado FROM cx_usu_web WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$valida = odbc_result($cur,1);
	if (trim($valida) == trim($estado))
	{
		$consecu = "0";
	}
	else
	{
		$consecu = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_estado.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $consecu;
	echo json_encode($salida);
}
?>
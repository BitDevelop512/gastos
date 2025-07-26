<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$clave = "827ccb0eea8a706c4c34a16891f84e7b";
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_usu_web");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_usu_web (conse, usuario, nombre, clave, permisos, conexion, estado, cambio, unidad, admin, usu_crea) VALUES ('$consecu', '$usuario', '$nombre', '$clave', '', '2', '1', '1', '0', '0', '$usu_usuario')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_usu_web WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_admin.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
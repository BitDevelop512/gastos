<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$nombre = $_POST['nombre'];
	$permisos = $_POST['permisos'];
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_ctr_rol");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_ctr_rol (conse, nombre, permisos, usuario) VALUES ('$consecu', '$nombre', '$permisos', '$usu_usuario')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_ctr_rol WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se retornan variables
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
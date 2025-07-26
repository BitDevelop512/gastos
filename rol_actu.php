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
	$nombre = $_POST['nombre'];
	$permisos = $_POST['permisos'];
	// Se actualiza la tabla con los nuevos valores
	$query = "UPDATE cx_ctr_rol SET nombre='$nombre', permisos='$permisos', usuario='$usu_usuario' WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_ctr_rol WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$consecu = odbc_result($cur,1);
	// Se retornan variables
	$salida = new stdClass();
	$salida->salida = $consecu;
	echo json_encode($salida);
}
?>
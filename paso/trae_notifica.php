<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	// Notificaciones
	$query = "SELECT COUNT(1) AS contador FROM cx_notifica WHERE usuario1='$usu_usuario' AND visto='1'";
	$cur = odbc_exec($conexion, $query);
	$contador = odbc_result($cur,1);
	// Mensajes informativos
	$query1 = "SELECT COUNT(1) AS contador1 FROM cx_men_usu WHERE usuario1='$usu_usuario' AND visto='1'";
	$cur1 = odbc_exec($conexion, $query1);
	$contador1 = odbc_result($cur1,1);
	$total = $contador+$contador1;
	$salida->contador = $total;
	$salida->mensajes = $contador1;
	echo json_encode($salida);
}
// 20/12/2023 - Contador mensajes informativos
?>
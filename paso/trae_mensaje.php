<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$query = "SELECT conse, mensaje FROM cx_men_usu WHERE usuario1='$usu_usuario' AND visto='1'";
	$cur = odbc_exec($conexion, $query);
	$conse = odbc_result($cur,1);
	$mensaje = utf8_encode(trim(odbc_result($cur,2)));
	$mensaje = "<br>".$mensaje;
	// Se desactiva mnensaje
	$query1 = "UPDATE cx_men_usu SET visto='0' WHERE usuario1='$usu_usuario' AND conse='$conse' AND visto='1'";
	$cur1 = odbc_exec($conexion, $query1);
	$salida->mensaje = $mensaje;
	echo json_encode($salida);
}
// 20/12/2023 - Contador mensajes informativos
?>
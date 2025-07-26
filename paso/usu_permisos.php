<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$usuario = $_POST['usuario'];
	$permisos = $_POST['permisos'];;
	$clase = $_POST['clase'];;
	$pregunta = "UPDATE cx_usu_web SET permisos='$permisos', super='$clase' WHERE usuario='$usuario'";
	if (!odbc_exec($conexion, $pregunta))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
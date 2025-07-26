<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$clave = trim($_POST['clave']);
	$password = md5($clave);
	$password1 = trim($_POST['clave1']);
	$salida = new stdClass();
	if ($password == $password1)
	{
		$salida->salida = "2";
	}
	else
	{
		// Se actualiza clave de usuario
		$pregunta = "UPDATE cx_usu_web SET clave='$password', cambio='0', valida=getdate() WHERE conse='$conse'";
		if (!odbc_exec($conexion, $pregunta))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
		}
		$salida->salida = $confirma;
		$_SESSION["cam_usuario"] = "0";
	}
	echo json_encode($salida);
}
?>
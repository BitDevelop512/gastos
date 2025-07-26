<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$nombre = trim($_POST['nombre']);
	$ruta = "fpdf/pdf/".$nombre;
	if (file_exists($ruta))
	{
		$archivo = "1";
	}
	else
	{
		$archivo = "0";
	}
	$salida->archivo = $archivo;
	echo json_encode($salida);
}
?>
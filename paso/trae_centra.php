<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$url = $_POST['url'];
	if (file_exists($url))
	{
		$salida->salida = "1";
	}
	else
	{
		$salida->salida = "0";
	}
}
echo json_encode($salida);
?>
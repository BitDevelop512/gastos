<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$acta = $_POST['acta'];
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$actu = "UPDATE cx_act_ver SET estado='A' WHERE conse='$conse' AND acta='$acta' AND ano='$ano'";
	if (!odbc_exec($conexion, $actu))
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
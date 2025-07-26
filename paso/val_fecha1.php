<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$fecha = $_POST['fecha'];
	$actual = date('Y-m-d');
	$dias1 = getDiasHabiles($fecha, $actual);
	$dias2 = count($dias1)-1;
	$salida = new stdClass();
	$salida->dias = $dias2;
	echo json_encode($salida);
}
?>
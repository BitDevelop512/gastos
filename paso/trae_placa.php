<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$placa = trim($_POST['placa']);
	$query = "SELECT * FROM cx_pla_tra WHERE placa='$placa'";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$salida = new stdClass();
	$salida->total = $total;
	echo json_encode($salida);
}
?>
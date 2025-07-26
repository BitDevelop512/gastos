<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$query = "SELECT ano FROM cx_ctr_ano WHERE ano='$ano'";
	$cur = odbc_exec($conexion, $query);
 	$total = odbc_num_rows($cur);
 	$salida = new stdClass();
 	$salida->salida = $total;
	echo json_encode($salida);
}
?>
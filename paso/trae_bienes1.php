<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$concepto = $_POST['concepto'];
	$query = "SELECT tipo FROM cx_ctr_pag WHERE codigo='$concepto'";
	$cur = odbc_exec($conexion, $query);
	$tipo = trim(odbc_result($cur,1));
	$salida->tipo = $tipo;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$directiva = $_POST['directiva'];
	$query = "SELECT nombre, tipo, valor1, valor2 FROM cx_ctr_dir WHERE codigo='$directiva'";
	$cur = odbc_exec($conexion, $query);
	$nombre = trim(utf8_encode(odbc_result($cur,1)));
	$tipo = odbc_result($cur,2);
	$valor1 = odbc_result($cur,3);
	$valor2 = odbc_result($cur,4);
	$salida = new stdClass();
	$salida->conse = $directiva;
	$salida->nombre = $nombre;
	$salida->tipo = $tipo;
	$salida->valor1 = $valor1;
	$salida->valor2 = $valor2;
	echo json_encode($salida);
}
?>
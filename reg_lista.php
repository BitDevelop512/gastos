<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$alea = trim($_POST['alea']);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$query = "SELECT lista FROM cx_reg_rec WHERE conse='$conse' AND usuario='$usuario' AND unidad='$unidad' AND codigo='$alea' AND tipo='0'";
	$cur = odbc_exec($conexion, $query);
	$lista = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_lista.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $lista;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$divisiones = $_POST['divisiones'];
	$brigadas = $_POST['brigadas'];
	$batallon = $_POST['batallon'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$tipo = $_POST['tipo'];
	$techo = $_POST['techo'];
	$batallon1 = $_POST['batallon1'];
	$batallon1 = strtr(trim($batallon1), $sustituye);
	$batallon1 = iconv("UTF-8", "ISO-8859-1", $batallon1);
	$tipo1 = $_POST['tipo1'];
	$especial = $_POST['especial'];
	$batallon2 = $_POST['batallon2'];
	$batallon3 = $_POST['batallon3'];
	$batallon3 = strtr(trim($batallon3), $sustituye);
	$batallon3 = iconv("UTF-8", "ISO-8859-1", $batallon3);
	$fecha = $_POST['fecha'];
	$query = "UPDATE cx_org_sub SET unidad='$divisiones', dependencia='$brigadas', sigla='$batallon', nombre='$batallon1', ciudad='$ciudad', tipo='$tipo', techo='$techo', unic='$tipo1', especial='$especial', sigla1='$batallon2', nombre1='$batallon3', fecha='$fecha' WHERE subdependencia='$conse'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT subdependencia FROM cx_org_sub WHERE subdependencia='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_bata.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
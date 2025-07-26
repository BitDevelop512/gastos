<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
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
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(subdependencia),0)+1 AS conse FROM cx_org_sub");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_org_sub (unidad, dependencia, subdependencia, sigla, nombre, ciudad, tipo, techo, unic, especial) VALUES ('$divisiones', '$brigadas', '$consecu', '$batallon', '$batallon1', '$ciudad', '$tipo', '$techo', '$tipo1', '$especial')";
	$sql = odbc_exec($conexion, $query);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_bata.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$query1 = "SELECT subdependencia FROM cx_org_sub WHERE subdependencia='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
// 26/02/2025 - Ajuste inclusion usuario en log
?>
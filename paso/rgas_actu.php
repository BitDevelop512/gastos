<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$responsable = trim($_POST['responsable']);
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$nombre = trim($_POST['nombre']);
	$cargo = trim($_POST['cargo']);
	$comandante = $nombre."»".$cargo;
	$comandante = iconv("UTF-8", "ISO-8859-1", $comandante);
	$elaboro = trim($_POST['elaboro']);
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$reviso = trim($_POST['reviso']);
	$reviso = iconv("UTF-8", "ISO-8859-1", $reviso);
	$graba = "UPDATE cx_rel_gas SET responsable='$responsable', comandante='$comandante', elaboro='$elaboro', reviso='$reviso' WHERE conse='$conse' AND ano='$ano'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_sopo_actu.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
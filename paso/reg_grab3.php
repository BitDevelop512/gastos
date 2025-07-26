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
	$lista = $_POST['lista'];
	$directiva = $_POST['directiva'];
	$actu = "UPDATE cx_reg_rec SET directiva='$directiva', lista='$lista' WHERE conse='$conse' AND ano='$ano'";
	if (!odbc_exec($conexion, $actu))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_rec_lista.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
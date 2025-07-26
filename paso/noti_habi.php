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
    // Se cambia el estado de la solicitud a disponible
	$graba = "UPDATE cx_pla_inv SET estado='' WHERE conse='$conse' AND ano='$ano' AND unidad='$uni_usuario'";
	$sql = odbc_exec($conexion, $graba);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_noti_dev.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = "1";
	echo json_encode($salida);
}
?>
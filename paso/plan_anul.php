<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$interno = $_POST['interno'];
	$ano = $_POST['ano'];
	$tipo = $_POST['tipo'];
	// Se actualiza el estado del plan / solicitud
	$query = "UPDATE cx_pla_inv  SET unidad='999', estado='X', uni_anu='$uni_usuario', fec_anu=getdate() WHERE conse='$interno' AND tipo='$tipo' AND ano='$ano'";
	$sql = odbc_exec($conexion, $query);
	// Se verifica el estado de anulacion
	$query1 = "SELECT estado FROM cx_pla_inv WHERE conse='$interno' AND tipo='$tipo' AND uni_anu='$uni_usuario' AND ano='$ano'";
	$cur1 = odbc_exec($conexion, $query1);
	$estado = odbc_result($cur1,1);

	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_anu.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);

	$salida = new stdClass();
	$salida->salida = $estado;
	echo json_encode($salida);
}
?>
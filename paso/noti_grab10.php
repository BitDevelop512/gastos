<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$motivo = $_POST['motivo'];
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	$ano = $_POST['ano'];
	// Se graba la observacion
	$query = "INSERT INTO cx_pla_rev (conse, usuario, unidad, estado, motivo, ano) VALUES ('$conse', '$usu_usuario', '$uni_usuario', 'Y', '$motivo', '$ano')";
	if (!odbc_exec($conexion, $query))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_recha.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu = odbc_result($cur1,1);
		$mensaje = "SU PLAN / SOLICITUD CON EL NUMERO ".$conse." HA SIDO RECHAZADO(A) POR: ".$motivo;
		// Se notifica al usuario que hizo el plan
		$query1 = "SELECT usuario FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
		$sql1 = odbc_exec($conexion,$query1);
		$usuario1 = trim(odbc_result($sql1,1));
		$unidad1 = $uni_usuario;
		$query2 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'Y', '1')";
		$sql2 = odbc_exec($conexion, $query2);
		// Se actualiza estado en la tabla cx_plan_inv y quien aprobo o rechazo
		$query3 = "UPDATE cx_pla_inv SET estado='Y', aprueba='$con_usuario', usuario13='$usu_usuario' WHERE conse='$conse' AND ano='$ano'";
		$sql3 = odbc_exec($conexion, $query3);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
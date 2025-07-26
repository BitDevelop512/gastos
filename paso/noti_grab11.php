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
	$motivo = $_POST['motivo'];
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	// Se graba la observacion
	$query = "INSERT INTO cx_pla_rev (conse, usuario, unidad, estado, motivo, ano) VALUES ('$conse', '$usu_usuario', '$uni_usuario', 'Z', '$motivo', '$ano')";
	if (!odbc_exec($conexion, $query))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_recha1.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
		$query0 = "UPDATE cx_act_cen SET estado='Y' WHERE conse='$conse' AND ano='$ano'";
		$sql0 = odbc_exec($conexion, $query0);
		// Se notifica al usuario que hizo el registro de recompensas
		$query1 = "SELECT registro, ano1 FROM cx_act_cen WHERE conse='$conse' AND ano='$ano'";
		$sql1 = odbc_exec($conexion,$query1);
		$registro = odbc_result($sql1,1);
		$ano1 = odbc_result($sql1,2);
		$query2 = "SELECT usuario, unidad FROM cx_reg_rec WHERE conse='$registro' AND ano='$ano1'";
		$sql2 = odbc_exec($conexion,$query2);
		$usuario1 = trim(odbc_result($sql1,1));
		$unidad1 = odbc_result($sql1,2);
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu = odbc_result($cur1,1);
		$mensaje = "SU SOLICITUD CON EL NUMERO ".$registro." / ".$ano1." HA SIDO RECHAZADA POR: ".$motivo;
		$query3 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$usuario1', '$unidad1', '$mensaje', 'Y', '1')";
		$sql3 = odbc_exec($conexion, $query3);
		// Se actualiza estado en la tabla y quien aprobo o rechazo
		$query4 = "UPDATE cx_reg_rec SET estado='Y', usuario5='$con_usuario' WHERE conse='$registro' AND ano='$ano1'";
		$sql4 = odbc_exec($conexion,$query4);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
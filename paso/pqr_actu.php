<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$fecha = date("d/m/Y H:i:s");
	$conse = $_POST['conse'];
	$ano = $_POST['ano'];
	$estado = $_POST['estado'];
	$carpeta = $_POST['carpeta'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$pregunta = "SELECT unidad FROM cx_usu_web WHERE usuario='$usuario'";
	$sql = odbc_exec($conexion, $pregunta);
	$unidad = odbc_result($sql,1);
	$respuesta = trim($_POST['respuesta']);
	$respuesta = iconv("UTF-8", "ISO-8859-1", $respuesta);
	$respuesta1 = trim($_POST['respuesta1']);
	$respuesta1 = iconv("UTF-8", "ISO-8859-1", $respuesta1);
	$respuesta = $respuesta1.$respuesta." - ".$usu_usuario." ".$fecha."<br>";
	$usuario1 = $_POST['usuario1'];
	$unidad1 = $_POST['unidad1'];
	$query = "UPDATE cx_pqr_reg SET solucion='$respuesta', estado='$estado', responde='$usuario1', asigna='$usuario' WHERE conse='$conse' AND ano='$ano' AND alea='$carpeta'";
	if (!odbc_exec($conexion, $query))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Se crea notificacion
		$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_notifica");
		$consecu1 = odbc_result($cur1,1);
		if ($estado == "D")
		{
			$mensaje = "<br>SE LE HA ASIGNADO LA SOLICITUD PQR CON EL INTERNO ".$conse." / ".$ano.".<br><br>";
		}
		else
		{
			$mensaje = "<br>SE HA DADO RESPUESTA A LA SOLICITUD PQR CON EL INTERNO ".$conse." / ".$ano.".<br><br>";
		}
		$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usuario1', '$unidad1', '$usuario', '$unidad', '$mensaje', 'S', '1')";
		$cur1 = odbc_exec($conexion, $query1);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_pqr.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$query1." # ".PHP_EOL);
		fwrite($file, " ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
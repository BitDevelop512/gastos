<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$tipo = $_POST['tipo'];
	$modulo = $_POST['modulo'];
	$modulo1 = $_POST['modulo1'];
	$alea = $_POST['alea'];
	$concepto = trim($_POST['concepto']);
	$concepto = iconv("UTF-8", "ISO-8859-1", $concepto);
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$telefono = trim($_POST['telefono']);
	$asignar = trim($_POST['asignar']);
	$asignar1 = $_POST['asignar1'];
	if ($asignar == "")
	{
		$estado = "";
	}
	else
	{
		$estado = "D";
	}
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pqr_reg WHERE ano='$ano'");
	$consecu = odbc_result($cur,1);
	$query = "INSERT INTO cx_pqr_reg (conse, usuario, unidad, estado, ano, tipo, modulo, submodulo, concepto, alea, contacto, telefono, asigna) VALUES ('$consecu', '$usuario', '$unidad', '$estado', '$ano', '$tipo', '$modulo', '$modulo1', '$concepto', '$alea', '$nombre', '$telefono', '$asignar')";
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
		if ($estado == "")
		{
			$mensaje = "<br>SE HA REGISTRADO EL SOPORTE TÉCNICO CON EL INTERNO ".$consecu." / ".$ano.".<br><br>";
			$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
			$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usuario', '$unidad', 'ADM_SIGAR', '2', '$mensaje', 'S', '1')";
			$cur1 = odbc_exec($conexion, $query1);
		}
		else
		{
			$mensaje = "<br>SE LE HA ASIGNADO AUTOMÁTICAMENTE EL SOPORTE TÉCNICO CON EL INTERNO ".$consecu." / ".$ano.".<br><br>";
			$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
			$query1 = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ('$consecu1', '$usuario', '$unidad', '$asignar', '$asignar1', '$mensaje', 'S', '1')";
			$cur1 = odbc_exec($conexion, $query1);
		}
		// Envio entre usuarios para calculo de tiempos
		$query2 = "INSERT INTO cx_pqr_usu (conse, usuario, usuario1, estado, solicitud, ano) VALUES ('$consecu1', '$usuario', '$asignar', '$estado', '$consecu', '$ano')";
		$cur2 = odbc_exec($conexion, $query2);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_pqr.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$query1." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, $fec_log." # ".$query2." # ".$usu_usuario." # ".PHP_EOL);
		fwrite($file, " ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 22/02/2024 - Ajuste para calculo de tiempos entre solicitud por usuarios
?>
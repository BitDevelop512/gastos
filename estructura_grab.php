<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$factor = $_POST['factor'];
	$conse = $_POST['conse'];
	$nombre = $_POST['nombre'];
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	if ($tipo == "1")
	{
		$cur = odbc_exec($conexion,"SELECT isnull(max(codigo),0)+1 AS conse FROM cx_ctr_est WHERE codigo<900");
		$conse = odbc_result($cur,1);
		$pregunta = "INSERT INTO cx_ctr_est (codigo, conse, nombre, estado) VALUES ('$conse', '$factor', '$nombre', '')";
		if (!odbc_exec($conexion, $pregunta))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
		}
	}
	else
	{
		if ($tipo == "2")
		{
			$estado = "X";
		}
		else
		{
			$estado = "";
		}
		$pregunta = "UPDATE cx_ctr_est SET estado='$estado' WHERE codigo='$conse' AND conse='$factor'";
		if (!odbc_exec($conexion, $pregunta))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
		}
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_estructuras.txt", "a");
	fwrite($file, $fec_log." # ".$pregunta." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$concepto = $_POST['concepto'];
	$unidad = $_POST['unidad'];
	$num_unidad = explode(",", $unidad);
	$unidad1 = $num_unidad[0];
	$unidad2 = $num_unidad[1];
	$sigla = $_POST['sigla'];
	$datos = $_POST['datos'];
	$datos = iconv("UTF-8", "ISO-8859-1", $datos);
	// Se cambian de estado registros anteriores
	$actu = "UPDATE cx_tra_ted SET estado='A' WHERE unidad='$unidad1' AND dependencia='$unidad2' AND tipo='$concepto'";
	odbc_exec($conexion, $actu);
	// Se graba registro
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_tra_ted");
	$conse = odbc_result($cur,1);
	$graba = "INSERT INTO cx_tra_ted (conse, usuario, ano, unidad, dependencia, sigla, tipo, datos) VALUES ('$conse', '$usu_usuario', '$ano', '$unidad1', '$unidad2', '$sigla', '$concepto', '$datos')";
	if (!odbc_exec($conexion, $graba))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_techo_transportes.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
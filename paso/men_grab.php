<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$usuario = $_POST['usuario'];
	$mensaje = trim($_POST['mensaje']);
	$mensaje = iconv("UTF-8", "ISO-8859-1", $mensaje);
	// Se eliminan mensajes anteriores
    $borra = "DELETE FROM cx_men_usu WHERE visto='0'";
    $sql = odbc_exec($conexion, $borra);
    // Se consultan usuarios activos en la base
	$pregunta = "SELECT usuario FROM cx_usu_web WHERE estado='1' ORDER BY conse";
	$cur = odbc_exec($conexion, $pregunta);
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$usuario1 = trim(odbc_result($cur,1));
		$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_men_usu)";
		$graba = "INSERT INTO cx_men_usu (conse, usuario, usuario1, mensaje, visto) VALUES ($query_c, '$usuario', '$usuario1', '$mensaje', '1')";
		if (!odbc_exec($conexion, $graba))
		{
	    	$confirma = "0";
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_mensajes_err.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fclose($file);
		}
		else
		{
			$confirma = "1";
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_mensajes_ok.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fclose($file);
		}
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 05/12/2023 - Ajuste campo dias de autorizacion
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$codigo = $_POST['codigo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	// Se consulta valor actual
  $pregunta = "SELECT valor FROM cx_pla_bie WHERE conse='$conse' AND codigo='$codigo'";
  $sql = odbc_exec($conexion, $pregunta);
  $valora = trim(odbc_result($sql,1));
	// Se actualiza nuevo valor
	$graba = "UPDATE cx_pla_bie SET valor='$valor', valor1='$valor1' WHERE conse='$conse' AND codigo='$codigo'";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Se crea notificacion
		$mensaje = "<br>SE MODIFICO EL VALOR DEL BIEN ".$codigo." DE ".$valora." A ".$valor." POR EL USUARIO ".$usu_usuario.".<br><br>";
	  $query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_notifica)";
		$query = "INSERT INTO cx_notifica (conse, usuario, unidad, usuario1, unidad1, mensaje, tipo, visto) VALUES ($query_c, '$usu_usuario', '$uni_usuario', 'ING_SIGAR', '1', '$mensaje', 'V', '1')";
  	odbc_exec($conexion, $query);
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_bienes_valor.txt", "a");
		fwrite($file, $fec_log." # ".$valora." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 21/01/2025 - Ajuste inclusion notificacion cambio de valor
?>
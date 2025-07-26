<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$placa = $_POST['placa'];
	$fecha = date("Y-m-d H:i:s");
	$pregunta = "SELECT autoriza FROM cx_ctr_par";
	$cur = odbc_exec($conexion, $pregunta);
  	$dias = odbc_result($cur,1);
	$autoriza = date("Y-m-d H:i:s",strtotime($fecha."+ ".$dias." days"));
	$autoriza = str_replace("/", "", $autoriza);
	$autoriza = str_replace("-", "", $autoriza);
	// Autorizacion
	$query_c = "(SELECT isnull(max(conse),0)+1 FROM cx_tra_aut)";
	$graba = "INSERT INTO cx_tra_aut (conse, usuario, placa, autoriza, estado) VALUES ($query_c, '$usu_usuario', '$placa', '$autoriza', 'A')";
	if (!odbc_exec($conexion, $graba))
	{
    	$confirma = "0";
	}
	else
	{
		$confirma = "1";
		// Log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_transportes_autoriza.txt", "a");
		fwrite($file, $fec_log." # ".$fecha." # ".$autoriza." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
		$graba1 = "UPDATE cx_pla_tra SET autoriza='1' WHERE placa='$placa'";
		odbc_exec($conexion, $graba1);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
// 05/12/2023 - Ajuste campo dias de autorizacion
?>
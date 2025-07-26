<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$crp = $_POST['crp'];
	$fecha = $_POST['fecha'];
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_crp_dis");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_crp_dis (conse, conse1, valor, valor1, tipo, usuario, fecha1) VALUES ('$consecu', '$crp', '$valor', '$valor1', '$tipo', '$usu_usuario', '$fecha')";
	$sql = odbc_exec($conexion, $query);
	// Se conslta saldo del CRP
	$pregunta = "SELECT saldo FROM cx_crp WHERE conse='$crp'";
	$cur2 = odbc_exec($conexion, $pregunta);
	$saldo = odbc_result($cur2,1);
	// Se actualiza saldo en la tabla cx_crp
	if ($tipo == "R")
	{
		$saldo = $saldo-$valor1;

	}
	else
	{
		if ($tipo == "A")
		{
			$saldo = $saldo+$valor1;
		}
		else
		{
			$saldo = $saldo;
		}
	}
	$pregunta2 = "UPDATE cx_crp SET saldo='$saldo' WHERE conse='$crp'";
	$cur3 = odbc_exec($conexion, $pregunta2);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_crp_dis WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ejecu.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	// Se retornan variables
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
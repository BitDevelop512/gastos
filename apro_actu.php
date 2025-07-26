<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = $_POST['ano'];
	$tipo = $_POST['tipo'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$fecha = $_POST['fecha'];
	$rubro = $_POST['rubro'];
	$recurso = $_POST['recurso'];
	$rubro1 = $_POST['rubro1'];
	$recurso1 = $_POST['recurso1'];
	// Se actualiza el saldo de la vigencia
	$cur0 = odbc_exec($conexion,"SELECT conse, saldo FROM cx_apropia WHERE ano='$ano'");
	$consecu1 = odbc_result($cur0,1);
	$saldo = odbc_result($cur0,2);
	if ($tipo == "A")
	{
		$saldo = $saldo+$valor1;
	}
	else
	{
		$saldo = $saldo-$valor1;
	}
	$query0 = "UPDATE cx_apropia SET saldo='$saldo' WHERE conse='$consecu1'";
	$sql0 = odbc_exec($conexion, $query0);
	// Se graba la adicion o la reduccion
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_apro_dis");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_apro_dis (conse, conse1, valor, valor1, tipo, usuario, fecha1, recurso, rubro, recurso1, rubro1) VALUES ('$consecu', '$ano', '$valor', '$valor1', '$tipo', '$usu_usuario', '$fecha', '$recurso', '$rubro', '$recurso1', '$rubro1')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_apro_dis WHERE conse='$consecu'";
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
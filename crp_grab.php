<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$cdp = $_POST['cdp'];
	$numero = $_POST['numero'];
	$fecha = $_POST['fecha'];
	$origen = $_POST['origen'];
	$recurso = $_POST['recurso'];
	$rubro = $_POST['rubro'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$destinacion = $_POST['destinacion'];
	$destinacion = iconv("UTF-8", "ISO-8859-1", $destinacion);
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_crp");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_crp (conse, conse1, numero, fecha1, origen, recurso, rubro, valor, valor1, destino, usuario, saldo) VALUES ('$consecu', '$cdp', '$numero', '$fecha', '$origen', '$recurso', '$rubro', '$valor', '$valor1', '$destinacion', '$usu_usuario', '$valor1')";
	$sql = odbc_exec($conexion, $query);
	// Se verifica grabacion de apropiacion
	$query1 = "SELECT conse FROM cx_crp WHERE conse='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);

	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_ejecu.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);

	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
?>
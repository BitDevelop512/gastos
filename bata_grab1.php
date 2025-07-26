<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$batallon = $_POST['batallon'];
	$batallon = iconv("UTF-8", "ISO-8859-1", $batallon);
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_org_bat");
	$consecu = odbc_result($cur1,1);
	$consecu = intval($consecu);
	if ($consecu == "1")
	{
		$consecu = "1000";
	}
	$query = "INSERT INTO cx_org_bat (conse, nombre) VALUES ('$consecu', '$batallon')";
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_batallones.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
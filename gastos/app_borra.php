<?php
session_start();
error_reporting(0);
require('../conf.php');
$usuario = $_REQUEST['usuario'];
$interno = $_REQUEST['interno'];
$borra = "UPDATE cx_usu_web SET firma='', imagen='' WHERE conse='$interno' AND usuario='$usuario'";
if (!odbc_exec($conexion, $borra))
{
	$confirma = "0";
}
else
{
	$confirma = "1";
}
$fec_log = date("d/m/Y H:i:s a");
$file = fopen("log_borra.txt", "a");
fwrite($file, $fec_log." # ".$usuario." # ".$interno." # ".$borra." # ".PHP_EOL);
fclose($file);
$salida->resultado = $confirma;
echo json_encode($salida);
?>
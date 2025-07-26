<?php
session_start();
error_reporting(0);
require('../conf.php');
$usuario = $_REQUEST['usuario'];
$interno = $_REQUEST['interno'];
$firma = trim($_REQUEST['firma']);
$firma1 = trim($_REQUEST['firma1']);
$graba = "UPDATE cx_usu_web SET firma='$firma1', imagen='$firma' WHERE conse='$interno' AND usuario='$usuario'";
if (!odbc_exec($conexion, $graba))
{
	$confirma = "0";
}
else
{
	$confirma = "1";
}
$fec_log = date("d/m/Y H:i:s a");
$file = fopen("log_app.txt", "a");
fwrite($file, $fec_log." # ".$usuario." # ".$interno." # ".$firma." # ".$firma1." # ".PHP_EOL);
fwrite($file, "".PHP_EOL);
fclose($file);
$salida->resultado = $confirma;
echo json_encode($salida);
?>
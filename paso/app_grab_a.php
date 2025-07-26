<?php
session_start();
error_reporting(0);
require('conf.php');
$usuario = $_REQUEST['usuario'];
$firma1 = $_REQUEST['firma1'];
$firma2 = $_REQUEST['firma2'];
$firma3 = $_REQUEST['firma3'];
$firma4 = $_REQUEST['firma4'];
$firma5 = $_REQUEST['firma5'];
$firma6 = $_REQUEST['firma6'];
$firma7 = $_REQUEST['firma7'];
$firma8 = $_REQUEST['firma8'];
$firma9 = $_REQUEST['firma9'];
$firma10 = $_REQUEST['firma10'];
$firma11 = $_REQUEST['firma11'];
$firma12 = $_REQUEST['firma12'];
$firma13 = $_REQUEST['firma13'];
$firma14 = $_REQUEST['firma14'];
$firma15 = $_REQUEST['firma15'];
$firma16 = $_REQUEST['firma16'];
$firma17 = $_REQUEST['firma17'];
$firma18 = $_REQUEST['firma18'];
$firma19 = $_REQUEST['firma19'];
$firma20 = $_REQUEST['firma20'];
$firma21 = $_REQUEST['firma21'];
$firma22 = $_REQUEST['firma22'];
$firma23 = $_REQUEST['firma23'];
$firma24 = $_REQUEST['firma24'];
$tipo = $_REQUEST['tipo'];
$firma1 = $firma1.$firma2.$firma3.$firma4.$firma5.$firma6;
$firma2 = $firma7.$firma8.$firma9.$firma10.$firma11.$firma12;
$firma3 = $firma13.$firma14.$firma15.$firma16.$firma17.$firma18;
$firma4 = $firma19.$firma20.$firma21.$firma22.$firma23.$firma24;
switch ($tipo)
{
	case '1':
		$query = "UPDATE cx_usu_web set firma='$firma1' WHERE usuario='$usuario'";
		break;
	case '2':
		$query = "UPDATE cx_usu_web set firma1='$firma2' WHERE usuario='$usuario'";
		break;
	case '3':
		$query = "UPDATE cx_usu_web set firma2='$firma3' WHERE usuario='$usuario'";
		break;
	case '4':
		$query = "UPDATE cx_usu_web set firma3='$firma4' WHERE usuario='$usuario'";
		break;
	default:
		break;
}
$cur = odbc_exec($conexion, $query);

$fec_log=date("d/m/Y H:i:s a");
$file=fopen("log_app.txt", "a");
fwrite($file, $fec_log." # ".$query." # ".$firma." # ".PHP_EOL);
fclose($file);

$mensaje="<div align='center'><br>Firma registrada correctamente.</div><br>";
$salida->salida = $mensaje;
echo json_encode($salida);
?>
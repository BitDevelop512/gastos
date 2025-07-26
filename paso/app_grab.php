<?php
session_start();
ini_set('max_input_vars', 3000);
ini_set('display_errors', 1);

//require('conf.php');
$usuario = $_REQUEST['usuario'];
$interno = $_REQUEST['interno'];
$firma1 = trim($_REQUEST['firma1']);
//$firma2 = trim($_REQUEST['firma2']);
//$firma3 = trim($_REQUEST['firma3']);

//switch ($tipo)
//{
//	case '1':
//		$query = "UPDATE cx_usu_web set firma='$firma1' WHERE usuario='$usuario'";
//		break;
//	case '2':
//		$query = "UPDATE cx_usu_web set firma1='$firma2' WHERE usuario='$usuario'";
//		break;
//	case '3':
//		$query = "UPDATE cx_usu_web set firma2='$firma3' WHERE usuario='$usuario'";
//		break;
//	case '4':
//		$query = "UPDATE cx_usu_web set firma3='$firma4' WHERE usuario='$usuario'";
//		break;
//	default:
//		break;
//}
//$cur = odbc_exec($conexion, $query);

$fec_log = date("d/m/Y H:i:s a");
$file = fopen("log_app.txt", "a");
//fwrite($file, $fec_log." # ".$usuario." # ".$interno." # ".$firma1." # ".$firma2." # ".$firma3." # ".PHP_EOL);
fwrite($file, $fec_log." # ".$usuario." # ".$interno." # ".$firma1." # ".PHP_EOL);
fclose($file);

$mensaje = "<div align='center'><br>Firma registrada correctamente.</div><br>";
$salida->salida = $mensaje;
echo json_encode($salida);
?>
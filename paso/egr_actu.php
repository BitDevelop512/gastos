<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	$concepto = $_POST['concepto'];
	$firma1 = $_POST['firma1'];
	$firma1 = iconv("UTF-8", "ISO-8859-1", $firma1);
	$firma2 = $_POST['firma2'];
	$firma2 = iconv("UTF-8", "ISO-8859-1", $firma2);
	$firma3 = $_POST['firma3'];
	$firma3 = iconv("UTF-8", "ISO-8859-1", $firma3);
	$firma4 = $_POST['firma4'];
	$firma4 = iconv("UTF-8", "ISO-8859-1", $firma4);
	$cargo1 = $_POST['cargo1'];
	$cargo1 = iconv("UTF-8", "ISO-8859-1", $cargo1);
	$cargo2 = $_POST['cargo2'];
	$cargo2 = iconv("UTF-8", "ISO-8859-1", $cargo2);
	$cargo3 = $_POST['cargo3'];
	$cargo3 = iconv("UTF-8", "ISO-8859-1", $cargo3);
	$cargo4 = $_POST['cargo4'];
	$cargo4 = iconv("UTF-8", "ISO-8859-1", $cargo4);
	$firmas = $firma1."»".$cargo1."|".$firma2."»".$cargo2."|".$firma3."»".$cargo3."|".$firma4."»".$cargo4;
	$firmas = encrypt1($firmas, $llave);
	$graba = "UPDATE cx_com_egr SET firmas='$firmas' WHERE egreso='$numero' AND ano='$ano' AND concepto='$concepto' AND usuario='$usu_usuario'";
  	// Log
    $fec_log = date("d/m/Y H:i:s a");
    $file = fopen("log_egr_actu.txt", "a");
    fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
    fclose($file);
  	if (!odbc_exec($conexion, $graba))
  	{
    	$confirma = "0";
  	}
  	else
  	{
    	$confirma = "1";
  	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
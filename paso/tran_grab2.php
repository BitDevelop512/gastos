<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$salida = new stdClass();
	$ano = date('Y');
	$tipo = $_POST['tipo'];
	$conses = $_POST['conses'];
	$conses1 = stringArray1($conses);
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$paso1 = $_POST['paso1'];
	$paso1 = str_replace('"', "", $paso1);
	$paso2 = $_POST['paso2'];
	$paso2 = str_replace('"', "", $paso2);
	$paso3 = $_POST['paso3'];
	$paso3 = str_replace('"', "", $paso3);
	$alea = $_POST['alea'];
	$num_paso1 = explode("|",$paso1);
	for ($i=0;$i<count($num_paso1);++$i)
	{
		$a[$i] = $num_paso1[$i];
	}
	$num_paso2 = explode("|",$paso2);
	for ($i=0;$i<count($num_paso2);++$i)
	{
		$b[$i] = $num_paso2[$i];
	}
	$num_paso3 = explode("|",$paso3);
	for ($i=0;$i<count($num_paso3);++$i)
	{
		$c[$i] = $num_paso3[$i];
	}
	if ($tipo == "1")
	{
		$acto = $_POST['acto'];
		$fecha = $_POST['fecha'];
		$unidad = $_POST['unidad'];
		$compania = trim($_POST['compania']);
		$compania = iconv("UTF-8", "ISO-8859-1", $compania);
		$observaciones = trim($_POST['observaciones']);
		$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_tra_mom WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_tra_mom (conse, usuario, unidad, unidad1, ano, tipo, codigo, placa, acto, fechat, observaciones, elaboro, alea) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$unidad', '$ano', '$tipo', '$a[$i]', '$b[$i]', '$acto', '$fecha', '$observaciones', '$elaboro', '$alea')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_transportes1.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fclose($file);
			// Actualiza 
			$graba1 = "UPDATE cx_pla_tra SET unidad='$unidad', compania='$compania' WHERE conse='$a[$i]' AND placa='$b[$i]'";
			$sql1 = odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_transportes2.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}
	echo json_encode($salida);
}
?>
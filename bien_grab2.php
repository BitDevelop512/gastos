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
	$tipo1 = $_POST['tipo1'];
	$conses = $_POST['conses'];
	$conses1 = stringArray1($conses);
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$paso1 = $_POST['paso1'];
	$paso2 = $_POST['paso2'];
	$paso3 = $_POST['paso3'];
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
		$responsable = trim($_POST['responsable']);
		$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
		$documento = $_POST['documento'];
		$fecha = $_POST['fecha'];
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_bie_mov (conse, tipo, tipo1, codigos, responsable, documento, fechad, ano, usuario, unidad, elaboro, dato1) VALUES ('$consecu', '$tipo', '0', '$b[$i]', '$responsable', '$documento', '$fecha', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
			// Actualiza
			$graba1 = "UPDATE cx_pla_bie SET compania='$a[$i]', responsable='$consecu', estado='$c[$i]' WHERE codigo='$b[$i]' AND responsable='0' AND responsable1='0'";
			$sql1 = odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes1.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}
	if ($tipo == "2")
	{
		if ($tipo1 == "1")
		{
			$alta = $_POST['alta'];
			$fecha1 = $_POST['fecha1'];
			$almacen = $_POST['almacen'];
			for ($i=0;$i<(count($num_paso1)-1);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND tipo1='$tipo1' AND ano='$ano'");
				$consecu = odbc_result($cur,1);
				$graba = "INSERT INTO cx_bie_mov (conse, tipo, tipo1, codigos, sap, alta, fechaa, almacen, ano, usuario, unidad, elaboro, dato1) VALUES ('$consecu', '$tipo', '$tipo1', '$b[$i]', '$a[$i]', '$alta', '$fecha1', '$almacen', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
				$sql = odbc_exec($conexion, $graba);
				// Log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_movi_bienes.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
				fclose($file);
				// Actualiza
				$pregunta = "SELECT unidad FROM cx_pla_bie WHERE codigo='$b[$i]' AND responsable!='0'";
				$sql0 = odbc_exec($conexion, $pregunta);
				$unidad = odbc_result($sql0,1);
				$graba1 = "UPDATE cx_pla_bie SET unidad='999', unidad_a='$unidad' WHERE codigo='$b[$i]' AND responsable!='0'";
				$sql1 = odbc_exec($conexion, $graba1);
				// Log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_movi_bienes1.txt", "a");
				fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
				fclose($file);
			}
		}
		if ($tipo1 == "2")
		{
			$fecha2 = $_POST['fecha2'];
			$siniestro = $_POST['siniestro'];
			$informe = $_POST['informe'];
			$fecha3 = $_POST['fecha3'];
			$acto = $_POST['acto'];
			$fecha4 = $_POST['fecha4'];
			$observaciones = trim($_POST['observaciones']);
			$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
			for ($i=0;$i<(count($num_paso1)-1);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND tipo1='$tipo1' AND ano='$ano'");
				$consecu = odbc_result($cur,1);
				$graba = "INSERT INTO cx_bie_mov (conse, tipo, tipo1, codigos, fechas, siniestro, informe, fechai, acto, fechac, observaciones, ano, usuario, unidad, elaboro, dato1) VALUES ('$consecu', '$tipo', '$tipo1', '$b[$i]', '$fecha2', '$siniestro', '$informe', '$fecha3', '$acto', '$fecha4', '$observaciones', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
				$sql = odbc_exec($conexion, $graba);
				// Log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_movi_bienes.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
				fclose($file);
				// Actualiza 
				$pregunta = "SELECT unidad FROM cx_pla_bie WHERE codigo='$b[$i]' AND responsable!='0'";
				$sql0 = odbc_exec($conexion, $pregunta);
				$unidad = odbc_result($sql0,1);
				$graba1 = "UPDATE cx_pla_bie SET unidad='888', unidad_a='$unidad' WHERE codigo='$b[$i]' AND responsable!='0'";
				$sql1 = odbc_exec($conexion, $graba1);
				// Log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_movi_bienes1.txt", "a");
				fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
				fclose($file);
			}
		}
		$salida->salida = "1";
	}
	if ($tipo == "3")
	{
		$acto1 = $_POST['acto1'];
		$fecha5 = $_POST['fecha5'];
		$orden = $_POST['orden'];
		$fecha6 = $_POST['fecha6'];
		$observaciones1 = trim($_POST['observaciones1']);
		$observaciones1 = iconv("UTF-8", "ISO-8859-1", $observaciones1);
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_bie_mov (conse, tipo, codigos, acto, fechac, informe, fechai, observaciones, ano, usuario, unidad, elaboro, dato1) VALUES ('$consecu', '$tipo', '$b[$i]', '$acto1', '$fecha5', '$orden', '$fecha6','$observaciones1', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
			// Actualiza 
			$pregunta = "SELECT unidad FROM cx_pla_bie WHERE codigo='$b[$i]'";
			$sql0 = odbc_exec($conexion, $pregunta);
			$unidad = odbc_result($sql0,1);
			$graba1 = "UPDATE cx_pla_bie SET unidad='777', unidad_a='$unidad' WHERE codigo='$b[$i]'";
			$sql1 = odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes1.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}
	if ($tipo == "4")
	{
		$acto2 = $_POST['acto2'];
		$fecha7 = $_POST['fecha7'];
		$unidad1 = $_POST['unidad'];
		$compania = $_POST['compania'];
		$ordop = trim($_POST['ordop']);
		$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
		$mision = trim($_POST['mision']);
		$mision = iconv("UTF-8", "ISO-8859-1", $mision);
		$observaciones2 = trim($_POST['observaciones2']);
		$observaciones2 = iconv("UTF-8", "ISO-8859-1", $observaciones2);
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_bie_mov (conse, tipo, codigos, acto, fechac, unidad1, dato1, dato2, observaciones, ano, usuario, unidad, elaboro, informe) VALUES ('$consecu', '$tipo', '$b[$i]', '$acto2', '$fecha7', '$unidad1', '$ordop', '$mision', '$observaciones2', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
			// Actualiza 
			$pregunta = "SELECT unidad FROM cx_pla_bie WHERE codigo='$b[$i]' AND responsable!='0'";
			$sql0 = odbc_exec($conexion, $pregunta);
			$unidad = odbc_result($sql0,1);
			$graba1 = "UPDATE cx_pla_bie SET responsable='0', responsable1='0', unidad='$unidad1', unidad_a='$unidad', compania='$compania', ordop1='$ordop', mision1='$mision' WHERE codigo='$b[$i]' AND responsable!='0'";
			$sql1 = odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes1.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}
	if ($tipo == "5")
	{
		$funcionario = trim($_POST['funcionario']);
		$funcionario = iconv("UTF-8", "ISO-8859-1", $funcionario);
		$documento1 = $_POST['documento1'];
		$fecha8 = $_POST['fecha8'];
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_bie_mov (conse, tipo, tipo1, codigos, responsable, documento, fechad, ano, usuario, unidad, elaboro, dato1) VALUES ('$consecu', '$tipo', '0', '$b[$i]', '$funcionario', '$documento1', '$fecha8', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
			// Actualiza
			$graba1 = "UPDATE cx_pla_bie SET responsable1='$consecu' WHERE codigo='$b[$i]' AND responsable!='0' AND responsable1='0'";
			$sql1 = odbc_exec($conexion, $graba1);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes1.txt", "a");
			fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}
	if ($tipo == "6")
	{
		$unidad1 = $_POST['unidad1'];
		if ($unidad1 == "999")
		{
			$unidad1 = 0;
		}
		$acta = $_POST['acta'];
		$fecha9 = $_POST['fecha9'];
		$observaciones3 = trim($_POST['observaciones3']);
		$observaciones3 = iconv("UTF-8", "ISO-8859-1", $observaciones3);
		for ($i=0;$i<(count($num_paso1)-1);++$i)
		{
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_bie_mov WHERE tipo='$tipo' AND ano='$ano'");
			$consecu = odbc_result($cur,1);
			$graba = "INSERT INTO cx_bie_mov (conse, tipo, codigos, acto, fechac, observaciones, ano, usuario, unidad, elaboro, dato1, unidad1) VALUES ('$consecu', '$tipo', '$b[$i]', '$acta', '$fecha9', '$observaciones3', '$ano', '$usu_usuario', '$uni_usuario', '$elaboro', '$alea', '$unidad1')";
			$sql = odbc_exec($conexion, $graba);
			// Log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_movi_bienes.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
			fclose($file);
		}
		$salida->salida = "1";
	}


	echo json_encode($salida);
}
?>
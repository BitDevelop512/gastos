<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$misiones = $_POST['misiones'];
	$factores = $_POST['factores'];
	$estructuras = $_POST['estructuras'];
	$actividades = $_POST['actividades'];
	$areas = $_POST['areas'];
	$fechas1 = $_POST['fechas1'];
	$fechas2 = $_POST['fechas2'];
	$oficiales = $_POST['oficiales'];
	$suboficiales = $_POST['suboficiales'];
	$auxiliares = $_POST['auxiliares'];
	$soldados = $_POST['soldados'];
	$gastos1 = $_POST['gastos1'];
	$gastos2 = $_POST['gastos2'];
	$gastos3 = $_POST['gastos3'];
	$gastos4 = $_POST['gastos4'];
	$gastos5 = $_POST['gastos5'];
	$ano = $_POST['ano'];
	$datos = "";
	$query = "UPDATE cx_pla_inv SET gastos='$datos', actual='1', estado='' WHERE conse='$conse' AND ano='$ano' AND unidad!='999'";
	$sql = odbc_exec($conexion, $query);
	// Se extraen las datos por separado para grabar
	$num_misiones = explode("|",$misiones);
	for ($i=0;$i<count($num_misiones);++$i)
	{
		$a[$i] = trim($num_misiones[$i]);
		$a[$i] = iconv("UTF-8", "ISO-8859-1", $a[$i]);
	}
	$num_areas = explode("|",$areas);
	for ($i=0;$i<count($num_areas);++$i)
	{
		$b[$i] = trim($num_areas[$i]);
		$b[$i] = iconv("UTF-8", "ISO-8859-1", $b[$i]);
	}
	$num_fechas1 = explode("|",$fechas1);
	for ($i=0;$i<count($num_fechas1);++$i)
	{
		$c[$i] = trim($num_fechas1[$i]);
	}
	$num_fechas2 = explode("|",$fechas2);
	for ($i=0;$i<count($num_fechas2);++$i)
	{
		$d[$i] = trim($num_fechas2[$i]);
	}
	$num_oficiales = explode("|",$oficiales);
	for ($i=0;$i<count($num_oficiales);++$i)
	{
		$e[$i] = trim($num_oficiales[$i]);
	}
	$num_suboficiales = explode("|",$suboficiales);
	for ($i=0;$i<count($num_suboficiales);++$i)
	{
		$f[$i] = trim($num_suboficiales[$i]);
	}
	$num_auxiliares = explode("|",$auxiliares);
	for ($i=0;$i<count($num_auxiliares);++$i)
	{
		$g[$i] = trim($num_auxiliares[$i]);
	}
	$num_soldados = explode("|",$soldados);
	for ($i=0;$i<count($num_soldados);++$i)
	{
		$h[$i] = trim($num_soldados[$i]);
	}
	$num_totales = explode("»",$gastos4);
	for ($i=0;$i<count($num_totales);++$i)
	{
		$v[$i] = trim($num_totales[$i]);
	}
	$num_actividades = explode("|",$actividades);
	for ($i=0;$i<count($num_actividades);++$i)
	{
		$w[$i] = trim($num_actividades[$i]);
	}
	$num_factores = explode("|",$factores);
	for ($i=0;$i<count($num_factores);++$i)
	{
		$p[$i] = trim($num_factores[$i]);
	}
	$num_estructuras = explode("|",$estructuras);
	for ($i=0;$i<count($num_estructuras);++$i)
	{
		$q[$i] = trim($num_estructuras[$i]);
	}
	// Se elimina discriminado anterior
	$borra = "DELETE FROM cx_pla_gas WHERE conse1='$conse' AND ano='$ano'";
	odbc_exec($conexion, $borra);
	$borra1 = "DELETE FROM cx_pla_gad WHERE conse1='$conse' AND ano='$ano'";
	odbc_exec($conexion, $borra1);
	// Se recorre por misiones
	for ($i=0;$i<(count($num_misiones)-1);++$i)
	{
		$j=$i+1;
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_gas");
		$consecu = odbc_result($cur,1);
		if ($tpc_usuario == "1")
		{
			$valor_a = $v[$i];
		}
		else
		{
			$valor_a = "0.00";
		}
		// Se graba discriminado de gastos
		$graba = "INSERT INTO cx_pla_gas (conse, conse1, interno, unidad, mision, area, fechai, fechaf, oficiales, suboficiales, auxiliares, soldados, valor, valor_a, actividades, factor, estructura, ano) VALUES ('$consecu', '$conse', '$j', '$unidad', '$a[$i]', '$b[$i]', '$c[$i]', '$d[$i]', '$e[$i]', '$f[$i]', '$g[$i]', '$h[$i]', '$v[$i]', '$valor_a', '$w[$i]', '$p[$i]', '$q[$i]', '$ano')";
		odbc_exec($conexion, $graba);
		// Se graba log
		$fec_log = date("d/m/Y H:i:s a");
		$file = fopen("log_plan_gas.txt", "a");
		fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
		fclose($file);
	}
	$num_gastos = explode("»", $gastos1);
	$num_gastos2 = explode("»", $gastos2);
	$num_gastos4 = explode("»", $gastos3);
	$num_gastos6 = explode("¥", $gastos5);
	for ($k=0;$k<(count($num_gastos)-1);++$k)
	{
		$j = $k+1;
		$v[$k] = $num_gastos[$k];
		$v2[$k] = $num_gastos2[$k];
		$v4[$k] = $num_gastos4[$k];
		$v6[$k] = $num_gastos6[$k];
		$num_gastos1 = explode("|", $v[$k]);
		$num_gastos3 = explode("|", $v2[$k]);
		$num_gastos5 = explode("|", $v4[$k]);
		$num_gastos7 = explode("»", $v6[$k]);
		for ($m=0;$m<(count($num_gastos1)-1);++$m)
		{
			$v1[$k] = $num_gastos1[$m];
			$v3[$k] = $num_gastos3[$m];
			$v5[$k] = $num_gastos5[$m];
			$v7[$k] = $num_gastos7[$m];
			$v7[$k] = iconv("UTF-8", "ISO-8859-1", $v7[$k]);
			if ($v1[$k] == "")
			{
			}
			else
			{
				// Se graba el detallado de gastos
				$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_pla_gad");
				$consecu1 = odbc_result($cur1,1);
				$graba1 = "INSERT INTO cx_pla_gad (conse, conse1, interno, unidad, gasto, otro, valor, bienes, ano) VALUES ('$consecu1', '$conse', '$j', '$unidad', '$v1[$k]', '$v3[$k]', '$v5[$k]', '$v7[$k]', '$ano')";
				odbc_exec($conexion, $graba1);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_plan_gad.txt", "a");
				fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
				fclose($file);
			}
		}
	}
	// Validacion de techos para calculos de ejecucion
	$borra2 = "DELETE FROM cx_tra_tev WHERE conse='$conse' AND ano='$ano' AND unidad='$unidad'";
	odbc_exec($conexion, $borra2);
	$graba2 = "INSERT INTO cx_tra_tev (conse, ano, unidad) VALUES ('$conse', '$ano', '$unidad')";
	odbc_exec($conexion, $graba2);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_tra_tev.txt", "a");
	fwrite($file, $fec_log." # ".$graba2." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	// Consulta de estado
	$query1 = "SELECT actual, estado FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	$estado = odbc_result($cur,2);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_plan.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $estado;
	echo json_encode($salida);
}
// 23/02/2024 - Ajuste para validación de valor ejecutado por techos
?>
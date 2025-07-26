<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$unidad = $_POST['unidad1'];
	$gastos = $_POST['gastos'];
	$pagos = $_POST['pagos'];
	$total = $_POST['total'];
	$datos1 = $_POST['datos1'];
	$datos2 = $_POST['datos2'];
	$datos3 = $_POST['datos3'];
	$datos4 = $_POST['datos4'];
	$datos5 = $_POST['datos5'];
	$datos6 = $_POST['datos6'];
	$datos7 = $_POST['datos7'];
	$plazo = $_POST['plazo'];
	$directiva = $_POST['directiva'];
	$instruccion = $_POST['instruccion'];
	$instruccion = iconv("UTF-8", "ISO-8859-1", $instruccion);
	$num_datos1 = explode("|",$datos1);
	for ($i=0;$i<count($num_datos1);++$i)
	{
		$a[$i] = trim($num_datos1[$i]);
	}
	$num_datos2 = explode("|",$datos2);
	for ($i=0;$i<count($num_datos2);++$i)
	{
		$b[$i] = trim($num_datos2[$i]);
	}
	$num_datos3 = explode("|",$datos3);
	for ($i=0;$i<count($num_datos3);++$i)
	{
		$c[$i] = trim($num_datos3[$i]);
	}
	$num_datos4 = explode("|",$datos4);
	for ($i=0;$i<count($num_datos4);++$i)
	{
		$d[$i] = trim($num_datos4[$i]);
	}
	$num_datos5 = explode("|",$datos5);
	for ($i=0;$i<count($num_datos5);++$i)
	{
		$e[$i] = trim($num_datos5[$i]);
	}
	if (trim($usu_usuario) == "")
	{
		$conse = 0;
	}
	else
	{
		// Se graba informe / cancelacion de giro
		if ($tipo == "1")
		{
			$tabla1 = "cx_inf_aut";
			$tabla2 = "cx_inf_dis";
			$autorizacion = "1";
		}
		else
		{
			$tabla1 = "cx_can_aut";
			$tabla2 = "cx_can_dis";
			$autorizacion = "2";
		}
		$pregunta = "SELECT isnull(max(conse),0)+1 AS conse FROM ".$tabla1." WHERE ano='$ano'";
		if (!odbc_exec($conexion, $pregunta))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
			$cur = odbc_exec($conexion, $pregunta);
		}
		if ($confirma == "0")
		{
			$conse = "0";
		}
		else
		{
			$consecu = odbc_result($cur,1);
			// Grabacion de informe de autorización autorizado
			$num_datos6 = explode("#",$datos6);
			for ($i=0;$i<count($num_datos6);++$i)
			{
				$f[$i] = trim($num_datos6[$i]);
				$num_gastos1 = explode("|",$f[$i]);
				for ($m=0;$m<(count($num_gastos1)-1);++$m)
				{
					$v1 = trim($num_gastos1[0]);
					$v2 = trim($num_gastos1[1]);
					// Se actualiza autorizacion de mision
					$actu = "UPDATE cx_pla_gas SET autoriza='$autorizacion', informe='$consecu' WHERE conse='$v2' AND conse1='$v1' AND ano='$ano'";
					odbc_exec($conexion, $actu);
					// Se graba log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_auto1.txt", "a");
					fwrite($file, $fec_log." # ".$actu." # ".$usu_usuario." # ".PHP_EOL);
					fclose($file);
				}
			}
			$num_datos7 = explode("#",$datos7);
			for ($i=0;$i<count($num_datos7);++$i)
			{
				$g[$i] = trim($num_datos7[$i]);
				$num_gastos2 = explode("|",$g[$i]);
				for ($m=0;$m<(count($num_gastos2)-1);++$m)
				{
					$v1 = trim($num_gastos2[0]);
					$v2 = trim($num_gastos2[1]);
					// Se actualiza autorizacion de mision
					$actu = "UPDATE cx_pla_pag SET autoriza='$autorizacion', informe='$consecu' WHERE conse='$v1' AND conse1='$v2' AND ano='$ano'";
					odbc_exec($conexion, $actu);
					// Se graba log
					$fec_log = date("d/m/Y H:i:s a");
					$file = fopen("log_auto2.txt", "a");
					fwrite($file, $fec_log." # ".$actu." # ".$usu_usuario." # ".PHP_EOL);
					fclose($file);
				}
			}
			if ($tipo == "1")
			{
				// Se graba informe de autorizacion
				$graba = "INSERT INTO cx_inf_aut (conse, usuario, unidad, periodo, ano, unidad1, gastos, pagos, total, plazo, directiva, otro) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$unidad', '$gastos', '$pagos', '$total', '$plazo', '$directiva', '$instruccion')";
			}
			else
			{
				// Se graba cancelacion de autorizacion
				$graba = "INSERT INTO cx_can_aut (conse, usuario, unidad, periodo, ano, unidad1, gastos, pagos, total, otro) VALUES ('$consecu', '$usu_usuario', '$uni_usuario', '$periodo', '$ano', '$unidad', '$gastos', '$pagos', '$total', '$instruccion')";
			}
			odbc_exec($conexion, $graba);
			// Se graba log
			$fec_log = date("d/m/Y H:i:s a");
			$file = fopen("log_auto.txt", "a");
			fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
			fclose($file);
			// Se verifica la grabacion
			$query1 = "SELECT conse FROM ".$tabla1." WHERE conse='$consecu' AND ano='$ano'";
			$cur = odbc_exec($conexion, $query1);
			$conse = odbc_result($cur,1);
			// Se graba discriminado de autorizaciones
			for ($i=0;$i<(count($num_datos1)-1);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM ".$tabla2);
				$consecu1 = odbc_result($cur,1);
				// Se graba discriminado de gastos
				$graba = "INSERT INTO ".$tabla2." (conse, conse1, unidad, dato, valor, tipo, compa, ano) VALUES ('$consecu1', '$consecu', '$unidad', '$a[$i]', '$b[$i]', '1', '$e[$i]', '$ano')";
				odbc_exec($conexion, $graba);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_auto.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
				fclose($file);
			}
			for ($i=0;$i<(count($num_datos3)-1);++$i)
			{
				$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM ".$tabla2);
				$consecu1 = odbc_result($cur,1);
				// Se graba discriminado de gastos
				$graba = "INSERT INTO ".$tabla2." (conse, conse1, unidad, dato, valor, tipo, compa, ano) VALUES ('$consecu1', '$consecu', '$unidad', '$c[$i]', '$d[$i]', '2', '0', '$ano')";
				odbc_exec($conexion, $graba);
				// Se graba log
				$fec_log = date("d/m/Y H:i:s a");
				$file = fopen("log_auto.txt", "a");
				fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
				fclose($file);
			}
		}
	}
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	echo json_encode($salida);
}
// 06/05/2024 - Ajuste nombre campo
// 10/12/2024 - Ajuste log
?>
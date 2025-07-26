<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$tipo = $_POST['tipo'];
	$tipo1 = $_POST['tipo1'];
	$placa = $_POST['placa'];
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$solicitud = $_POST['plan'];
	$mision = $_POST['mision'];
	list($plan, $mision1) = explode("¬", $mision);
	$mision1 = iconv("UTF-8", "ISO-8859-1", $mision1);
	$soporte = $_POST['soporte'];
	$kilometraje = $_POST['kilometraje'];
	$kilometraje = str_replace(",", ".", $kilometraje);
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_veri_transportes.txt", "a");
	fwrite($file, $fec_log." # ".$placa." # ".$kilometraje." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$kilometraje = str_replace('.','',$kilometraje);
	$kilometraje = floatval($kilometraje);
	$consumo = $_POST['consumo'];
	$consumo = floatval($consumo);
	$precio = $_POST['precio'];
	$precio1 = $_POST['precio1'];
	$precio1 = floatval($precio1);
	$odometro = $_POST['odometro'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$elaboro = $_POST['elaboro'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$borrar = $_POST['borrar'];
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_tra_mov");
	$consecu = odbc_result($cur,1);
	$busca = "SELECT conse FROM cx_tra_mov WHERE fecha='$fecha' AND placa='$placa'";
	$sql = odbc_exec($conexion, $busca);
	$total = odbc_num_rows($sql);
	if ($total > 0)
	{
		$id = odbc_result($sql,1);
	}
	else
	{
		$id = "0";
	}
	if ($borrar == "0")
	{
		$graba = "INSERT INTO cx_tra_mov (conse, fecha, usuario, unidad, placa, consumo, kilometraje, valor, valor1, total, solicitud, mision, ano, elaboro, tipo, soporte) VALUES ('$consecu', '$fecha', '$usuario', '$unidad', '$placa', '$consumo', '$kilometraje', '$precio', '$precio1', '$precio1', '$solicitud', '$mision1', '$ano', '$elaboro', '$tipo1', '$soporte')";
		if (!odbc_exec($conexion, $graba))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
			$graba1 = "UPDATE cx_pla_tra SET kilometro='$kilometraje' WHERE placa='$placa'";
			$sql1 = odbc_exec($conexion, $graba1);
			if ($odometro == "1")
			{
				$graba2 = "UPDATE cx_pla_tra SET odometro='0' WHERE placa='$placa' AND odometro='1'";
				$sql2 = odbc_exec($conexion, $graba2);
			}
		}
	}
	else
	{
		$borra = "DELETE FROM cx_tra_mov WHERE fecha='$fecha' AND placa='$placa'";
		$cur = odbc_exec($conexion, $borra);
		$graba = "";
		$confirma = "1";	
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_movi_transportes.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$graba1." # ".$usu_usuario." # ".PHP_EOL);
	if ($odometro == "1")
	{
		fwrite($file, $fec_log." # ".$graba2." # ".$usu_usuario." # ".PHP_EOL);
	}
	if ($borrar == "1")
	{
		fwrite($file, $fec_log." # ".$borra." # ".$usu_usuario." # ".PHP_EOL);
	}
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->conse = $consecu;
	$salida->id = $id;
	echo json_encode($salida);
}
// 08/08/2023 - Log verificacion valor consumo antes de convertir
?>
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
	$contrato = $_POST['contrato'];
	$contrato1 = $_POST['contrato1'];
	$kilometraje = $_POST['kilometraje'];
	$kilometraje = str_replace(",", ".", $kilometraje);
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_veri_contratol.txt", "a");
	fwrite($file, $fec_log." # ".$placa." # ".$kilometraje." # ".$usu_usuario." # ".PHP_EOL);
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$kilometraje = str_replace('.','',$kilometraje);
	$kilometraje = floatval($kilometraje);
	$precio = $_POST['precio'];
	$precio1 = $_POST['precio1'];
	$precio1 = floatval($precio1);
	$alea = $_POST['alea'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$borrar = $_POST['borrar'];
	$valores = $_POST['valores'];
	$valores = strtr(trim($valores), $sustituye);
	$valores = iconv("UTF-8", "ISO-8859-1", $valores);
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_tra_lla");
	$consecu = odbc_result($cur,1);
	$busca = "SELECT conse FROM cx_tra_lla WHERE fecha='$fecha' AND placa='$placa'";
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
		$graba = "INSERT INTO cx_tra_lla (conse, fecha, usuario, unidad, placa, kilometraje, valores, total, total1, contrato, contrato1, ano, elaboro, alea) VALUES ('$consecu', '$fecha', '$usu_usuario', '$uni_usuario', '$placa', '$kilometraje', '$valores', '$precio', '$precio1', '$contrato', '$contrato1', '$ano', '$elaboro', '$alea')";
		if (!odbc_exec($conexion, $graba))
		{
			$confirma = "0";
		}
		else
		{
			$confirma = "1";
		}
	}
	else
	{
		$borra = "DELETE FROM cx_tra_lla WHERE fecha='$fecha' AND placa='$placa'";
		$cur = odbc_exec($conexion, $borra);
		$graba = "";
		$confirma = "1";
	}
	// Log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_movi_transportes_llantas.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
	fwrite($file, $fec_log." # ".$borra." # ".PHP_EOL);
	fwrite($file, $fec_log." ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->conse = $consecu;
	$salida->id = $id;
	echo json_encode($salida);
}
// 19/12/2023 - Grabacion de llantas
?>
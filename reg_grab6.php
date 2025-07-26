<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$conse = $_POST['conse'];
	$batallon = $_POST['batallon'];
	$brigada = $_POST['brigada'];
	$division = $_POST['division'];
	$nombre = $_POST['nombre'];
	$nombre = strtr(trim($nombre), $sustituye);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$cedula = $_POST['cedula'];
	$concepto = $_POST['concepto'];
	$acto = $_POST['acto'];
	$numero = $_POST['numero'];
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$solicitud = $_POST['plan'];
	$ano = $_POST['ano'];
	$ordop = $_POST['ordop'];
	$ordop = strtr(trim($ordop), $sustituye);
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$ofrag = $_POST['ofrag'];
	$ofrag = strtr(trim($ofrag), $sustituye);
	$ofrag = iconv("UTF-8", "ISO-8859-1", $ofrag);
	$fecha1 = $_POST['fecha1'];
	$fecha1 = str_replace("/", "", $fecha1);
	$fecha1 = str_replace("-", "", $fecha1);
	$unidad1 = $_POST['unidad1'];
	$unidad1 = strtr(trim($unidad1), $sustituye);
	$unidad1 = iconv("UTF-8", "ISO-8859-1", $unidad1);
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$fecha2 = $_POST['fecha2'];
	$fecha2 = str_replace("/", "", $fecha2);
	$fecha2 = str_replace("-", "", $fecha2);
	$motivo = $_POST['motivo'];
	$motivo = strtr(trim($motivo), $sustituye);
	$motivo = iconv("UTF-8", "ISO-8859-1", $motivo);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	if ($tipo == "1")
	{
		// Se consulta el maximo de registros por año
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_reg_acr");
		$consecu = odbc_result($cur,1);
		$query = "INSERT INTO cx_reg_acr (conse, usuario, unidad, batallon, brigada, division, nombre, cedula, concepto, acto, num_act, fec_act, solicitud, ano, ordop, ofrag, fec_res, uni_res, valor, valor1, fec_con, motivo) VALUES ('$consecu', '$usuario', '$unidad', '$batallon', '$brigada', '$division', '$nombre', '$cedula', '$concepto', '$acto', '$numero', '$fecha', '$solicitud', '$ano', '$ordop', '$ofrag', '$fecha1', '$unidad1', '$valor', '$valor1', '$fecha2', '$motivo')";
	}
	else
	{
		$consecu = $conse;
		$query = "UPDATE cx_reg_acr SET batallon='$batallon', brigada='$brigada', division='$division', nombre='$nombre', cedula='$cedula', concepto='$concepto', acto='$acto', num_act='$numero', fec_act='$fecha', solicitud='$solicitud', ano='$ano', ordop='$ordop', ofrag='$ofrag', fec_res='$fecha1', uni_res='$unidad1', valor='$valor', valor1='$valor1', fec_con='$fecha2', motivo='$motivo' WHERE conse='$conse' AND batallon='$batallon'";
	}
	if (!odbc_exec($conexion, $query))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_acreedores.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->consecu = $consecu;
	echo json_encode($salida);
}
?>
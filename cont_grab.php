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
	$contrato = trim($_POST['contrato']);
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$tipo1 = $_POST['tipo1'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$objeto = $_POST['objeto'];
	$objeto = strtr(trim($objeto), $sustituye);
	$objeto = iconv("UTF-8", "ISO-8859-1", $objeto);
	$supervisor = trim($_POST['supervisor']);
	$supervisor = iconv("UTF-8", "ISO-8859-1", $supervisor);
	$nit = $_POST['nit'];
	$proveedor = trim($_POST['proveedor']);
	$proveedor = iconv("UTF-8", "ISO-8859-1", $proveedor);
	$fecha1 = $_POST['fecha1'];
	$fecha1 = str_replace("/", "", $fecha1);
	$fecha1 = str_replace("-", "", $fecha1);
	$fecha2 = $_POST['fecha2'];
	$fecha2 = str_replace("/", "", $fecha2);
	$fecha2 = str_replace("-", "", $fecha2);
	$crp = $_POST['crp'];
	$cdp = $_POST['cdp'];
	$datos = $_POST['datos'];
	$datos = strtr(trim($datos), $sustituye);
	$datos = iconv("UTF-8", "ISO-8859-1", $datos);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$alea = $_POST['alea'];
	// Se validan datos en blanco
	if (trim($usuario) == "")
	{
		$conse = 0;
	}
	else
	{
		if ($tipo == "1")
		{
			// Se consulta el maximo de registros por año
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_con_pro");
			$consecu = odbc_result($cur,1);
			$query = "INSERT INTO cx_con_pro (conse, usuario, unidad, estado, numero, fec_con, objeto, valor, valor1, supervisor, proveedor, nit, fec_ini, fec_fin, cdp, crp, datos, alea, tipo) VALUES ('$consecu', '$usuario', '$unidad', '', '$contrato', '$fecha', '$objeto', '$valor', '$valor1', '$supervisor', '$proveedor', '$nit', '$fecha1', '$fecha2', '$cdp', '$crp', '$datos', '$alea', '$tipo1')";
		}
		else
		{
			$consecu = $conse;
			$query = "UPDATE cx_con_pro SET numero='$contrato', fec_con='$fecha', objeto='$objeto', valor='$valor', valor1='$valor1', supervisor='$supervisor', proveedor='$proveedor', nit='$nit', fec_ini='$fecha1', fec_fin='$fecha2', cdp='$cdp', crp='$crp', datos='$datos', tipo='$tipo1' WHERE conse='$conse' AND alea='$alea'";
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
		$file = fopen("log_contratos.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->consecu = $consecu;
	echo json_encode($salida);
}
?>
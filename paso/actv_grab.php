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
	$acta = trim($_POST['acta']);
	$conse = $_POST['conse'];
	$ano1 = $_POST['ano'];
	$lugar = $_POST['lugar'];
	$lugar = strtr(trim($lugar), $sustituye);
	$lugar = iconv("UTF-8", "ISO-8859-1", $lugar);
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$fecha = str_replace("-", "", $fecha);
	$centraliza = $_POST['centraliza'];
	$centraliza = strtr(trim($centraliza), $sustituye);
	$centraliza = iconv("UTF-8", "ISO-8859-1", $centraliza);
	$periodo = $_POST['periodo'];
	$plan = $_POST['plan'];
	$fecha1 = $_POST['fecha1'];
	$fecha1 = str_replace("/", "", $fecha1);
	$fecha1 = str_replace("-", "", $fecha1);
	$fecha2 = $_POST['fecha2'];
	$fecha2 = str_replace("/", "", $fecha2);
	$fecha2 = str_replace("-", "", $fecha2);
	$firmas = $_POST['firmas'];
	$firmas = strtr(trim($firmas), $sustituye);
	$firmas = iconv("UTF-8", "ISO-8859-1", $firmas);
	$firmas1 = $_POST['firmas1'];
	$firmas1 = strtr(trim($firmas1), $sustituye);
	$firmas1 = iconv("UTF-8", "ISO-8859-1", $firmas1);
	$firmas2 = $_POST['firmas2'];
	$firmas2 = strtr(trim($firmas2), $sustituye);
	$firmas2 = iconv("UTF-8", "ISO-8859-1", $firmas2);
	$documentos = $_POST['documentos'];
	$documentos = strtr(trim($documentos), $sustituye);
	$documentos = iconv("UTF-8", "ISO-8859-1", $documentos);
	$aspectos = $_POST['aspectos'];
	$aspectos = strtr(trim($aspectos), $sustituye);
	$aspectos = iconv("UTF-8", "ISO-8859-1", $aspectos);
	$observaciones = $_POST['observaciones'];
	$observaciones = strtr(trim($observaciones), $sustituye);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$recomendaciones = $_POST['recomendaciones'];
	$recomendaciones = strtr(trim($recomendaciones), $sustituye);
	$recomendaciones = iconv("UTF-8", "ISO-8859-1", $recomendaciones);
	$reconocimientos = $_POST['reconocimientos'];
	$reconocimientos = strtr(trim($reconocimientos), $sustituye);
	$reconocimientos = iconv("UTF-8", "ISO-8859-1", $reconocimientos);
	$actividades = $_POST['actividades'];
	$actividades = strtr(trim($actividades), $sustituye);
	$actividades = iconv("UTF-8", "ISO-8859-1", $actividades);
	$elaboro = trim($_POST['elaboro']);
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$reviso = trim($_POST['reviso']);
	$reviso = iconv("UTF-8", "ISO-8859-1", $reviso);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
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
			$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_act_ver WHERE ano='$ano'");
			$consecu = odbc_result($cur,1);
			$query = "INSERT INTO cx_act_ver (conse, usuario, unidad, estado, ano, acta, lugar, fec_act, centraliza, periodo, planes, fec_ini, fec_ter, responsable, documentos, aspectos, observaciones, recomendaciones, reconocimientos, actividades, funcionarios, elaboro, reviso, presentan) VALUES ('$consecu', '$usuario', '$unidad', '', '$ano', '$acta', '$lugar', '$fecha', '$centraliza', '$periodo', '$plan', '$fecha1', '$fecha2', '$firmas', '$documentos', '$aspectos', '$observaciones', '$recomendaciones', '$reconocimientos', '$actividades', '$firmas1', '$elaboro', '$reviso', '$firmas2')";
		}
		else
		{
			$consecu = $conse;
			$query = "UPDATE cx_act_ver SET acta='$acta', lugar='$lugar', fec_act='$fecha', centraliza='$centraliza', periodo='$periodo', planes='$plan', fec_ini='$fecha1', fec_ter='$fecha2', responsable='$firmas', documentos='$documentos', aspectos='$aspectos', observaciones='$observaciones', recomendaciones='$recomendaciones', reconocimientos='$reconocimientos', actividades='$actividades', funcionarios='$firmas1', elaboro='$elaboro', reviso='$reviso', presentan='$firmas2' WHERE conse='$conse' AND ano='$ano1'";
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
		$file = fopen("log_verificacion.txt", "a");
		fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
		fclose($file);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	$salida->consecu = $consecu;
	$salida->ano = $ano;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
ini_set('post_max_size','1024M');
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$ano = date('Y');
	$actividades = $_POST['actividades'];
	$actividades = strtr(trim($actividades), $sustituye);
	$actividades = iconv("UTF-8", "ISO-8859-1", $actividades);
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$aspectos = $_POST['aspectos'];
	$aspectos = strtr(trim($aspectos), $sustituye);
	$aspectos = iconv("UTF-8", "ISO-8859-1", $aspectos);
	$bienes = $_POST['bienes'];
	$bienes = strtr(trim($bienes), $sustituye);
	$bienes = iconv("UTF-8", "ISO-8859-1", $bienes);
	$personal = $_POST['personal'];
	$personal = strtr(trim($personal), $sustituye);
	$personal = iconv("UTF-8", "ISO-8859-1", $personal);
	$equipo = $_POST['equipo'];
	$equipo = iconv("UTF-8", "ISO-8859-1", $equipo);
	$equipo = strtr(trim($equipo), $sustituye);
	$responsable = $_POST['responsable'];
	$responsable = iconv("UTF-8", "ISO-8859-1", $responsable);
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$conse = $_POST['paso'];
	$numero = $_POST['paso1'];
	$consecu = $_POST['paso2'];
	// Se actualiza acta
	$actu = "UPDATE cx_inf_eje SET actividades='$actividades', sintesis='$sintesis', aspectos='$aspectos', bienes='$bienes', personal='$personal', equipo='$equipo', responsable='$responsable', elaboro='$elaboro' WHERE conse='$conse' AND numero='$numero' AND consecu='$consecu' AND unidad='$uni_usuario' AND ano='$ano'";
	odbc_exec($conexion, $actu);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_info_act.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->ano = $ano;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$centra = $_POST['centra'];
	$batallon = $_POST['batallon'];
	$sigla = $_POST['sigla'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$resumen = $_POST['resumen'];
	$resumen = iconv("UTF-8", "ISO-8859-1", $resumen);
	$resumen = strtr(trim($resumen), $sustituye);
	$numero = $_POST['numero'];
	$fecha = $_POST['fecha'];
	$fecha = str_replace("/", "", $fecha);
	$ordop = $_POST['ordop'];
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$cedulas = trim($_POST['cedulas']);
	$nombres = trim($_POST['nombres']);
	$nombres = strtr(trim($nombres), $sustituye);
	$nombres = iconv("UTF-8", "ISO-8859-1", $nombres);
	$porcentajes = trim($_POST['porcentajes']);
	$porcentajes1 = trim($_POST['porcentajes1']);
	$actas = trim($_POST['actas']);
	$fechas = trim($_POST['fechas']);
	$valores = trim($_POST['valores']);
	$valores1 = trim($_POST['valores1']);
	$informantes = $_POST['informantes'];
	$alea = trim($_POST['alea']);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_rec_man");
	$conse = odbc_result($cur,1);
	$graba = "INSERT INTO cx_rec_man (conse, usuario, unidad, periodo, ano, num_acta, fec_acta, resumen, valor, cedulas, nombres, porcentajes, porcentajes1, actas, fechas, valores, valores1, acta, informantes, codigo) VALUES ('$conse', '$usuario', '$batallon', '$periodo', '$ano', '$numero', '$fecha', '$resumen', '$valor1', '$cedulas', '$nombres', '$porcentajes', '$porcentajes1', '$actas', '$fechas', '$valores', '$valores1', '0', '$informantes', '$alea')";
	odbc_exec($conexion, $graba);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_rec_man.txt", "a");
	fwrite($file, $fec_log." # ".$graba." # ".PHP_EOL);
	fclose($file);
	// Se consultan datos complementarios
	$pregunta = "SELECT unidad, dependencia FROM cx_org_sub WHERE subdependencia='$batallon'";
    $ejecuta = odbc_exec($conexion, $pregunta);
    $v_unidad = odbc_result($ejecuta,1);
    $v_dependencia = odbc_result($ejecuta,2);
    // Dependnecia
	$pregunta1 = "SELECT nombre FROM cx_org_dep WHERE dependencia='$v_dependencia'";
    $ejecuta1 = odbc_exec($conexion, $pregunta1);
    $nombre1 = trim(odbc_result($ejecuta1,1));
    // Unidad
	$pregunta2 = "SELECT nombre FROM cx_org_uni WHERE unidad='$v_unidad'";
    $ejecuta2 = odbc_exec($conexion, $pregunta2);
    $nombre2 = trim(odbc_result($ejecuta2,1));
    // Se graba en la tabla cx_val_aut2
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_val_aut2");
	$consecu = odbc_result($cur1,1);
	$graba1 = "INSERT INTO cx_val_aut2 (conse, usuario, unidad, periodo, ano, sigla, valor, total, depen, n_depen, uom, n_uom, estado, aprueba, ordop, solicitud, registro, pago, ano1) VALUES ('$consecu', '$usuario', '$batallon', '$periodo', '$ano', '$sigla', '$valor1', '$valor1', '$v_dependencia', '$nombre1', '$v_unidad', '$nombre2', 'V', '$usuario', '$ordop', '0', '$conse', '0', '0')";
	$cur2 = odbc_exec($conexion, $graba1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_val_aut2.txt", "a");
	fwrite($file, $fec_log." # ".$graba1." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $consecu;
	echo json_encode($salida);
}
?>
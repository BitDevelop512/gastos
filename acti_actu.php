<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['plan'];
	$plan = $_POST['fuente'];
	$fuente = $_POST['fuente1'];
	$fuente = iconv("UTF-8", "ISO-8859-1", $fuente);
	$numero = trim($_POST['numero']);
	$numero = iconv("UTF-8", "ISO-8859-1", $numero);
	$testigo = $_POST['testigo'];
	$testigo = iconv("UTF-8", "ISO-8859-1", $testigo);
	$utilidad = $_POST['utilidad'];
	$utilidad = strtr(trim($utilidad), $sustituye);
	$utilidad = iconv("UTF-8", "ISO-8859-1", $utilidad);
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$empleo = $_POST['empleo'];
	$empleo = strtr(trim($empleo), $sustituye);
	$empleo = iconv("UTF-8", "ISO-8859-1", $empleo);
	$observa = $_POST['observa'];
	$observa = strtr(trim($observa), $sustituye);
	$observa = iconv("UTF-8", "ISO-8859-1", $observa);
	$difusion = $_POST['difusion'];
	$uni_dif = $_POST['uni_dif'];
	$num_dif = $_POST['num_dif'];
	$fec_dif = $_POST['fec_dif'];
	$pys = $_POST['pys'];
	$ano = $_POST['ano'];
	$elaboro = $_POST['elaboro'];
	$elaboro = iconv("UTF-8", "ISO-8859-1", $elaboro);
	$cargo = $_POST['cargo'];
	$cargo = iconv("UTF-8", "ISO-8859-1", $cargo);
	$firmas = $_POST['firmas'];
	$firmas = encrypt1($firmas, $llave);
	// Se actualiza acta
	$actu = "UPDATE cx_act_inf SET numero='$numero', testigo='$testigo', utilidad='$utilidad', sintesis='$sintesis', difusion='$difusion', unidad1='$uni_dif', num_dif='$num_dif', fec_dif='$fec_dif', pys='$pys', firmas='$firmas', empleo='$empleo', observacion='$observa', elaboro='$elaboro', cargo='$cargo' WHERE conse='$conse' AND fuente='$fuente' AND pla_inv='$plan' AND usuario='$usu_usuario' AND unidad='$uni_usuario' AND ano='$ano'";
	odbc_exec($conexion, $actu);
	// Se valida que se grabe
	$query1 = "SELECT conse FROM cx_act_inf WHERE conse='$conse' AND ano='$ano'";
	$cur2 = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur2,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_acta_actu.txt", "a");
	fwrite($file, $fec_log." # ".$actu." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	// Se envia el estado actual para verificacion de grabacion
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->ano = $ano;
	echo json_encode($salida);
}
// 31/07/2024 - Ajuste inclusion cargo reviso
// 19/03/2025 - Ajuste campo testigo caracteres especiales
?>
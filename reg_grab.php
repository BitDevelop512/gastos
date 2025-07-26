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
	$conse = $_POST['conse'];
	$fec_res = $_POST['fec_res'];
	$fechas = explode("/",$fec_res);
	$ano1 = $fechas[0];
	$hr = $_POST['hr'];
	$fec_hr = $_POST['fec_hr'];
	$dias = $_POST['dias'];
	$oficio = $_POST['oficio'];
	$fec_ofi = $_POST['fec_ofi'];
	$prorroga = $_POST['prorroga'];
	$fec_pro = $_POST['fec_pro'];
	$unidad1 = $_POST['unidad1'];
	$unidad2 = $_POST['unidad2'];
	$nsigla1 = trim($_POST['nsigla1']);
	$nsigla2 = trim($_POST['nsigla2']);
	$brigada = $_POST['brigada'];
	$division = $_POST['division'];
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$fec_sum = $_POST['fec_sum'];
	$ordop1 = $_POST['ordop1'];
	$ordop1 = iconv("UTF-8", "ISO-8859-1", $ordop1);
	$ordop = $_POST['ordop'];
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$fec_ord = $_POST['fec_ord'];
	$fragmentaria = $_POST['fragmentaria'];
	$fragmentaria = iconv("UTF-8", "ISO-8859-1", $fragmentaria);
	$fec_fra = $_POST['fec_fra'];
	$sitio = $_POST['sitio'];
	$sitio = iconv("UTF-8", "ISO-8859-1", $sitio);
	$municipio = $_POST['municipio'];
	$departamento = $_POST['departamento'];
	$factor = $_POST['factor'];
	$estructura = $_POST['estructura'];
	$resultado = $_POST['resultado'];
	$resultado = strtr(trim($resultado), $sustituye);
	$resultado = iconv("UTF-8", "ISO-8859-1", $resultado);
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
	$observaciones = $_POST['observaciones'];
	$observaciones = strtr(trim($observaciones), $sustituye);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$directiva = $_POST['directiva'];
	$estado = $_POST['estado'];
	$alea = trim($_POST['alea']);
	$tipo1 = $_POST['tipo1'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	if ($tipo1 == "1")
	{
		$unidad = $unidad1;
	}
	if ($tipo == "1")
	{
		// Se consulta el maximo de registros por año
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_reg_rec WHERE ano='$ano'");
		$consecu = odbc_result($cur,1);
		$query = "INSERT INTO cx_reg_rec (conse, usuario, unidad, ciudad, ano, fec_res, hr, fec_hr, dias, oficio, fec_ofi, prorroga, fec_pro, uni_man, uni_efe, brigada, division, sintesis, valor, valor1, fec_sum, n_ordop, ordop, fec_ord, fragmenta, fec_fra, sitio, municipio, departamento, factor, estructura, resultado, cedulas, nombres, porcentajes, porcentajes1, actas, fechas, valores, valores1, observaciones, directiva, codigo, tipo1, lista, usuario1, usuario2, usuario3, usuario4, usuario5, ano1, tipo, sig_man, sig_efe) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$ano', '$fec_res', '$hr', '$fec_hr', '$dias', '$oficio', '$fec_ofi', '$prorroga', '$fec_pro', '$unidad1', '$unidad2', '$brigada', '$division', '$sintesis', '$valor', '$valor1', '$fec_sum', '$ordop1', '$ordop', '$fec_ord', '$fragmentaria', '$fec_fra', '$sitio', '$municipio', '$departamento', '$factor', '$estructura', '$resultado', '$cedulas', '$nombres', '$porcentajes', '$porcentajes1', '$actas', '$fechas', '$valores', '$valores1', '$observaciones', '$directiva', '$alea', '$tipo1', '', '', '', '', '', '', '$ano1', '0', '$nsigla1', '$nsigla2')";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT conse FROM cx_reg_rec WHERE conse='$consecu' AND ano='$ano'";
		$cur1 = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur1,1);
	}
	else
	{
		$query = "UPDATE cx_reg_rec SET estado='$estado', fec_res='$fec_res', hr='$hr', fec_hr='$fec_hr', dias='$dias', oficio='$oficio', fec_ofi='$fec_ofi', prorroga='$prorroga', fec_pro='$fec_pro', uni_man='$unidad1', uni_efe='$unidad2', brigada='$brigada', division='$division', sintesis='$sintesis', valor='$valor', valor1='$valor1', fec_sum='$fec_sum', n_ordop='$ordop1', ordop='$ordop', fec_ord='$fec_ord', fragmenta='$fragmentaria', fec_fra='$fec_fra', sitio='$sitio', municipio='$municipio', departamento='$departamento', factor='$factor', estructura='$estructura', resultado='$resultado', cedulas='$cedulas', nombres='$nombres', porcentajes='$porcentajes', porcentajes1='$porcentajes1', actas='$actas', fechas='$fechas', valores='$valores', valores1='$valores1', observaciones='$observaciones', directiva='$directiva', sig_man='$nsigla1', sig_efe='$nsigla2' WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='0'";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT ano FROM cx_reg_rec WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='0'";
		$cur1 = odbc_exec($conexion, $query1);
		$ano = odbc_result($cur1,1);
	}
	$query2 = "SELECT lista FROM cx_reg_rec WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='0'";
	$cur2 = odbc_exec($conexion, $query2);
	$lista = odbc_result($cur2,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_recomp.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $ano;
	$salida->salida2 = $lista;
	echo json_encode($salida);
}
?>
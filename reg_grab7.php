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
	$cedula = trim($_POST['cedula'])."|";
	$nombre = trim($_POST['nombre']);
	$nombre = strtr(trim($nombre), $sustituye);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre)."|";
	$factor = $_POST['factor'];
	$estructura = $_POST['estructura'];
	$oms = $_POST['oms'];
	$oms = stringArray1($oms);
	$valor = $_POST['valor'];
	$valor1 = $_POST['valor1'];
	$fec_sum = $_POST['fec_sum'];
	$sintesis = $_POST['sintesis'];
	$sintesis = strtr(trim($sintesis), $sustituye);
	$sintesis = iconv("UTF-8", "ISO-8859-1", $sintesis);
	$dias = $_POST['dias'];
	$oficio = $_POST['oficio'];
	$fec_ofi = $_POST['fec_ofi'];
	$recoleccion = $_POST['recoleccion'];
	$numero1 = $_POST['numero1'];
	$fecha1 = $_POST['fecha1'];
	$difusion = $_POST['difusion'];
	$numero2 = $_POST['numero2'];
	$fecha2 = $_POST['fecha2'];
	$uni_efe = $_POST['uni_efe'];
	$resultado1 = $_POST['resultado1'];
	$radiograma = $_POST['radiograma'];
	$directiva = $_POST['directiva'];
	$fecha3 = $_POST['fecha3'];
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
	$resultado = $_POST['resultado'];
	$resultado = strtr(trim($resultado), $sustituye);
	$resultado = iconv("UTF-8", "ISO-8859-1", $resultado);
	$observaciones = $_POST['observaciones'];
	$observaciones = strtr(trim($observaciones), $sustituye);
	$observaciones = iconv("UTF-8", "ISO-8859-1", $observaciones);
	$porcentajes = "100.000|";
	$porcentajes1 = "100|";
	$actas = "0|";
	$fechas = "|";
	$valores = "0.00|";
	$valores1 = "0|";
	$alea = trim($_POST['alea']);
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$ciudad = $_POST['ciudad'];
	$ciudad = iconv("UTF-8", "ISO-8859-1", $ciudad);
	if ($tipo == "1")
	{
		// Se consulta el maximo de registros por año
		$cur = odbc_exec($conexion,"SELECT isnull(max(conse),0)+1 AS conse FROM cx_reg_rec WHERE ano='$ano'");
		$consecu = odbc_result($cur,1);
		$query = "INSERT INTO cx_reg_rec (conse, usuario, unidad, ciudad, ano, dias, oficio, fec_ofi, uni_man, uni_efe, sintesis, valor, valor1, fec_sum, n_ordop, ordop, fec_ord, fragmenta, fec_fra, sitio, municipio, departamento, factor, estructura, resultado, cedulas, nombres, porcentajes, porcentajes1, actas, fechas, valores, valores1, codigo, tipo1, ano1, tipo, oms, recoleccion, num_reco, fec_reco, difusion, num_difu, fec_difu, condujo, radiograma, fec_radi, directiva, observaciones) VALUES ('$consecu', '$usuario', '$unidad', '$ciudad', '$ano', '$dias', '$oficio', '$fec_ofi', '0', '$uni_efe', '$sintesis', '$valor', '$valor1', '$fec_sum', '$ordop1', '$ordop', '$fec_ord', '$fragmentaria', '$fec_fra', '$sitio', '$municipio', '$departamento', '$factor', '$estructura', '$resultado', '$cedula', '$nombre', '$porcentajes', '$porcentajes1', '$actas', '$fechas', '$valores', '$valores1', '$alea', '0', '$ano', '1', '$oms', '$recoleccion', '$numero1', '$fecha1', '$difusion', '$numero2', '$fecha2', '$resultado1', '$radiograma', '$fecha3', '$directiva', '$observaciones')";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT conse FROM cx_reg_rec WHERE conse='$consecu' AND ano='$ano'";
		$cur1 = odbc_exec($conexion, $query1);
		$conse = odbc_result($cur1,1);
	}
	else
	{
		$query = "UPDATE cx_reg_rec SET cedulas='$cedula', nombres='$nombre', dias='$dias', oficio='$oficio', fec_ofi='$fec_ofi', uni_efe='$uni_efe', sintesis='$sintesis', valor='$valor', valor1='$valor1', fec_sum='$fec_sum', n_ordop='$ordop1', ordop='$ordop', fec_ord='$fec_ord', fragmenta='$fragmentaria', fec_fra='$fec_fra', sitio='$sitio', municipio='$municipio', departamento='$departamento', factor='$factor', estructura='$estructura', resultado='$resultado', oms='$oms', recoleccion='$recoleccion', num_reco='$numero1', fec_reco='$fecha1', difusion='$difusion', num_difu='$numero2', fec_difu='$fecha2', condujo='$resultado1', radiograma='$radiograma', fec_radi='$fecha3', directiva='$directiva', observaciones='$observaciones' WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='1'";
		$sql = odbc_exec($conexion, $query);
		$query1 = "SELECT ano FROM cx_reg_rec WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='1'";
		$cur1 = odbc_exec($conexion, $query1);
		$ano = odbc_result($cur1,1);
	}
	$query2 = "SELECT lista FROM cx_reg_rec WHERE conse='$conse' AND unidad='$unidad' AND codigo='$alea' AND tipo='1'";
	$cur2 = odbc_exec($conexion, $query2);
	$lista = odbc_result($cur2,1);
	// Se graba log
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_informacion.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $ano;
	$salida->salida2 = $lista;
	echo json_encode($salida);
}
?>
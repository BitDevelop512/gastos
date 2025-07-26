<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$plan = $_POST['plan'];
	$usuario = $_POST['usuario'];
	$unidad = $_POST['unidad'];
	$lugar = $_POST['lugar'];
	$lugar = strtr(trim($lugar), $sustituye);
	$lugar = iconv("UTF-8", "ISO-8859-1", $lugar);
	$lugar = strtoupper($lugar);
	$lugar = encrypt1($lugar, $llave);
	$factor = stringArray1($_POST['factor']);
	$factor1 = stringArray($_POST['factor']);
	$estructura = stringArray1($_POST['estructura']);
	$estructura1 = stringArray($_POST['estructura']);
	$oms = $_POST['oms'];
	$oms = stringArray1($oms);
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$oficiales = $_POST['oficiales'];
	$suboficiales = $_POST['suboficiales'];
	$auxiliares = $_POST['auxiliares'];
	$soldados = $_POST['soldados'];
	$ordop = trim($_POST['ordop']);
	$ordop = iconv("UTF-8", "ISO-8859-1", $ordop);
	$ordop = strtoupper($ordop);
	$ordop = trim(utf8_encode($ordop));
	$ordop = encrypt1($ordop, $llave);
	$ordop1 = trim($_POST['ordop1']);
	$ordop1 = iconv("UTF-8", "ISO-8859-1", $ordop1);
	$ordop1 = strtoupper($ordop1);
	$ordop1 = trim(utf8_encode($ordop1));
	$ordop1 = encrypt1($ordop1, $llave);
	$misiones = $_POST['misiones'];
	$misiones = encrypt1($misiones, $llave);
	$nivel = $_POST['nivel'];
	$query = "UPDATE cx_pla_inv SET usuario='$usuario', lugar='$lugar', factor='$factor', estructura='$estructura', oms='$oms', periodo='$periodo', oficiales='$oficiales', suboficiales='$suboficiales', auxiliares='$auxiliares', soldados='$soldados', n_ordop='$ordop1', ordop='$ordop', misiones='$misiones', tipo='$plan', compania='$tip_usuario', nivel='$nivel' WHERE conse='$conse' AND ano='$ano' AND unidad!='999'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT conse, estado FROM cx_pla_inv WHERE conse='$conse' AND ano='$ano'";
	$cur = odbc_exec($conexion, $query1);
	$conse = odbc_result($cur,1);
	$estado = odbc_result($cur,2);
	$query2 = "SELECT nombre, codigo FROM cx_ctr_fac WHERE codigo IN ($factor1) ORDER BY codigo";
	$sql2 = odbc_exec($conexion, $query2);
	$nom_fact = "";
	$nom_fact1 = "";
  	while($i<$row=odbc_fetch_array($sql2))
  	{
    	$nom_fact .= utf8_encode(trim(odbc_result($sql2,1))).", ";
    	$nom_fact1 .= "<option value='".odbc_result($sql2,2)."'>".utf8_encode(trim(odbc_result($sql2,1)))."</option>";
  	}
  	$nom_fact = substr($nom_fact, 0, -2);
	$query3 = "SELECT nombre, codigo FROM cx_ctr_est WHERE codigo IN ($estructura1) ORDER BY codigo";
	$sql3 = odbc_exec($conexion, $query3);
	$nom_estr = "";
	$nom_estr1 = "";
  	while($i<$row=odbc_fetch_array($sql3))
  	{
    	$nom_estr .= utf8_encode(trim(odbc_result($sql3,1))).", ";
    	$nom_estr1 .= "<option value='".odbc_result($sql3,2)."'>".utf8_encode(trim(odbc_result($sql3,1)))."</option>";
  	}
  	$nom_estr = substr($nom_estr, 0, -2);
	$fec_log = date("d/m/Y H:i:s a");
	$file = fopen("log_plan.txt", "a");
	fwrite($file, $fec_log." # ".$query." # ".$usu_usuario." # ".PHP_EOL);
	fclose($file);
	$salida = new stdClass();
	$salida->salida = $conse;
	$salida->salida1 = $estado;
	$salida->factores = $nom_fact;
	$salida->factores1 = $nom_fact1;
	$salida->estructuras = $nom_estr;
	$salida->estructuras1 = $nom_estr1;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$numero = $_POST['numero'];
	$ano = $_POST['ano'];
	$pregunta = "SELECT valor, firmas, periodo, fecha, concepto, gasto, recurso, rubro, soporte, num_sopo, fec_sopo, transferencia, origen, estado FROM cx_com_ing WHERE ingreso='$numero' AND ano='$ano' AND usuario='$usu_usuario'";
	$cur = odbc_exec($conexion, $pregunta);
	$total = odbc_num_rows($cur);
	$valor = odbc_result($cur,1);
	$firmas = odbc_result($cur,2);
	$firmas = decrypt1($firmas, $llave);
	$firmas = utf8_encode($firmas);
	$periodo = odbc_result($cur,3);
	$fecha = odbc_result($cur,4);
	$fecha = substr($fecha,0,10);
	$concepto = odbc_result($cur,5);
	$gasto = odbc_result($cur,6);
	$recurso = odbc_result($cur,7);
	$rubro = odbc_result($cur,8);
	$soporte = odbc_result($cur,9);
	$num_sopo = trim(odbc_result($cur,10));
	$fec_sopo = trim(odbc_result($cur,11));
	$transferencia = odbc_result($cur,12);
	$origen = trim(odbc_result($cur,13));
	$estado = trim(odbc_result($cur,14));
	$salida = new stdClass();
	$salida->salida = $total;
	$salida->valor = $valor;
	$salida->firmas = $firmas;
	$salida->periodo = $periodo;
	$salida->fecha = $fecha;
	$salida->concepto = $concepto;
	$salida->gasto = $gasto;
	$salida->recurso = $recurso;
	$salida->rubro = $rubro;
	$salida->soporte = $soporte;
	$salida->num_sopo = $num_sopo;
	$salida->fec_sopo = $fec_sopo;
	$salida->transferencia = $transferencia;
	$salida->origen = $origen;
	$salida->estado = $estado;
	echo json_encode($salida);
}
?>
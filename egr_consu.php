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
	$pregunta = "SELECT total, datos, firmas, periodo, fecha, concepto, tp_gas, recurso, rubro, autoriza, num_auto, soporte, num_sopo, pago, det_pago, estado FROM cx_com_egr WHERE egreso='$numero' AND ano='$ano' AND usuario='$usu_usuario'";
	$cur = odbc_exec($conexion, $pregunta);
	$total = odbc_num_rows($cur);
	$valor = odbc_result($cur,1);
	$datos = odbc_result($cur,2);
	$datos = decrypt1($datos, $llave);
	$datos = utf8_encode($datos);
	$firmas = odbc_result($cur,3);
	$firmas = decrypt1($firmas, $llave);
	$firmas = utf8_encode($firmas);
	$periodo = odbc_result($cur,4);
	$fecha = odbc_result($cur,5);
	$fecha = substr($fecha,0,10);
	$concepto = odbc_result($cur,6);
	$tp_gas = odbc_result($cur,7);
	$recurso = odbc_result($cur,8);
	$rubro = odbc_result($cur,9);
	$autoriza = odbc_result($cur,10);
	$num_auto = trim(odbc_result($cur,11));
	$soporte = odbc_result($cur,12);
	$num_sopo = trim(odbc_result($cur,13));
	$pago = odbc_result($cur,14);
	$det_pago = odbc_result($cur,15);
	$estado = trim(odbc_result($cur,16));
	$salida = new stdClass();
	$salida->salida = $total;
	$salida->valor = $valor;
	$salida->datos = $datos;
	$salida->firmas = $firmas;
	$salida->periodo = $periodo;
	$salida->fecha = $fecha;
	$salida->concepto = $concepto;
	$salida->tp_gas = $tp_gas;
	$salida->recurso = $recurso;
	$salida->rubro = $rubro;
	$salida->autoriza = $autoriza;
	$salida->num_auto = $num_auto;
	$salida->soporte = $soporte;
	$salida->num_sopo = $num_sopo;
	$salida->pago = $pago;
	$salida->det_pago = $det_pago;
	$salida->estado = $estado;
	echo json_encode($salida);
}
?>
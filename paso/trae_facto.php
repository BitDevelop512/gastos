<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$factor = $_POST['factor'];
	$conse = $_POST['conse'];
	// Se consultan las estructuras del plan
	$pregunta = "SELECT estructura FROM cx_pla_inv WHERE conse='$conse'";	
	$sql = odbc_exec($conexion, $pregunta);
	$estruc = trim(odbc_result($sql,1));
	// Se convierte resultado para consultar
	$num_estruc = explode(",",$estruc);
	for ($i=0;$i<count($num_estruc);++$i)
	{
		$estructura .= "'".$num_estruc[$i]."',";
	}
	$estructura = substr($estructura, 0, -1);
	// Consulta por los dos campos
	$query = "SELECT * FROM cx_ctr_est WHERE conse='$factor' AND codigo IN ($estructura) ORDER BY codigo";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = trim(utf8_encode(odbc_result($cur,3)));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
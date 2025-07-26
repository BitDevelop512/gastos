<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$municipio = $_POST['municipio'];
	$query = "SELECT conse FROM cx_ctr_ciu WHERE codigo='$municipio' ORDER BY codigo";
	$cur = odbc_exec($conexion, $query);
	$dpto = odbc_result($cur,1);
	$query0 = "SELECT * FROM cx_ctr_dep WHERE codigo='$dpto' ORDER BY codigo";
	$cur0 = odbc_exec($conexion, $query0);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur0))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur0,1);
	    $cursor["nombre"] = utf8_encode(odbc_result($cur0,2));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
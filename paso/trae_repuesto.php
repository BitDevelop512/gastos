<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$query = "SELECT codigo, nombre, medida, tipo FROM cx_ctr_rep WHERE estado='' ORDER BY nombre";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = trim(utf8_encode(odbc_result($cur,2)));
	    $cursor["medida"] = odbc_result($cur,3);
	    $cursor["tipo"] = odbc_result($cur,4);
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
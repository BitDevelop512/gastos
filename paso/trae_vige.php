<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_apropia ORDER BY ano DESC";	
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur,5);
	    $cursor["nombre"] = trim(odbc_result($cur,5));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
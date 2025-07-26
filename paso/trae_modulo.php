<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$modulo = $_POST['modulo'];
	$query = "SELECT * FROM cx_ctr_mod WHERE modulo='$modulo' ORDER BY conse";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$cursor["conse"] = odbc_result($cur,1);
		$cursor["nombre"] = trim(utf8_encode(odbc_result($cur,4)));
		array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
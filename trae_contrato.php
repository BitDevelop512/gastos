<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	$query = "SELECT conse, numero FROM cx_con_pro WHERE tipo='$tipo' ORDER BY numero";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["conse"] = odbc_result($cur,1);
	    $cursor["numero"] = trim(utf8_encode(odbc_result($cur,2)));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
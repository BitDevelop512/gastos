<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$query = "SELECT ano FROM cx_ctr_ano ORDER BY ano DESC";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$ano = trim(odbc_result($cur,1));
		$cursor["ano"] = $ano;
		array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
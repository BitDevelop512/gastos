<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$valor = $_POST['valor'];
	switch ($valor)
	{
		case '0':
			$query = "SELECT subdependencia, sigla FROM cx_org_sub ORDER BY sigla";
			break;
		case '1':
			$query = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unic='1' ORDER BY sigla";
			break;
		default:
			$query = "SELECT subdependencia, sigla FROM cx_org_sub ORDER BY sigla";
			break;
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$cursor["codigo"] = odbc_result($cur,1);
		$cursor["nombre"] = trim(utf8_encode(odbc_result($cur,2)));
		array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
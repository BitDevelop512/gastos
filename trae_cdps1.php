<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$mes = date('m');
	$ano = date('Y');
	$ano1 = intval($ano)-1;
	if (($mes == "1") or ($mes == "2") or ($mes == "3"))
	{
		$query = "SELECT conse, numero FROM cv_cdp4 WHERE (vigencia='$ano1' OR vigencia='$ano') ORDER BY conse";
	}
	else
	{
		$query = "SELECT conse, numero FROM cv_cdp4 WHERE vigencia='$ano' ORDER BY conse";
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
		$cursor["codigo"] = odbc_result($cur,1);
		$cursor["nombre"] = odbc_result($cur,2);
		array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
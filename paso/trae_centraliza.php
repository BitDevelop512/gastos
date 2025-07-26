<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$pregunta = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unic='1' AND subdependencia!='301' ORDER BY sigla";
	$cur = odbc_exec($conexion, $pregunta);
	$respuesta = array();
	$unidades = "";
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$sigla = trim(utf8_encode(odbc_result($cur,1)));
		$unidades .= $sigla."|";
		$i++;
	}
	$salida->salida = $unidades;
	echo json_encode($salida);
}
?>
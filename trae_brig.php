<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_org_dep ORDER BY nombre";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$respuesta = array();
	if ($total>0)
	{
		$i=0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$cursor=array();
		    $cursor["dependencia"] = odbc_result($cur,2);
		    $cursor["nombre"] = utf8_encode(trim(odbc_result($cur,3)));
		    array_push($respuesta, $cursor);
			$i++;
		}
	}
	else
	{	
		$cursor=array();
	    $cursor["dependencia"] = "0";
	    $cursor["nombre"] = "NO EXISTEN BRIGADAS";
		array_push($respuesta, $cursor);
	}
	echo json_encode($respuesta);
}
// 03/07/2024 - Ajuste ordenamiento brigadas por nombre
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT * FROM cx_org_uni ORDER BY unidad";
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$respuesta = array();
	if ($total>0)
	{
		$i=0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$cursor=array();
		    $cursor["unidad"] = odbc_result($cur,1);
		    $cursor["nombre"] = utf8_encode(trim(odbc_result($cur,2)));
		    array_push($respuesta, $cursor);
			$i++;
		}
	}
	else
	{	
		$cursor=array();
	    $cursor["unidad"] = "0";
	    $cursor["nombre"] = "NO EXISTEN DIVISIONES";
		array_push($respuesta, $cursor);
	}
	echo json_encode($respuesta);
}
?>
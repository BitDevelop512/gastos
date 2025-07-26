<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	if ($unidad == "1")
	{
		$query = "SELECT subdependencia, sigla FROM cx_org_sub WHERE (unidad='$unidad' OR unic='1') ORDER BY sigla";
	}
	else
	{
		if (($unidad == "2") or ($unidad == "3"))
		{
	    	$query1 = "SELECT dependencia FROM cx_org_sub WHERE subdependencia='$uni_usuario'";
	      	$cur1 = odbc_exec($conexion, $query1);
	      	$n_dependencia = odbc_result($cur1,1);
			$query = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$unidad' AND dependencia='$n_dependencia' ORDER BY sigla";
		}
		else
		{
			$query = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$unidad' ORDER BY sigla";
		}
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
	// Se verifica si es unidad centralizadora especial
	if (strpos($especial, $uni_usuario) !== false)
	{
	    $query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$nun_usuario' ORDER BY unidad";
    	$cur = odbc_exec($conexion, $query);
    	$i = 0;
    	while($i<$row=odbc_fetch_array($cur))
    	{
			$n_unidad = odbc_result($cur,1);
			$n_dependencia = odbc_result($cur,2);
			$query1 = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
			$cur1 = odbc_exec($conexion, $query1);
			while($j<$row=odbc_fetch_array($cur1))
			{
				$cursor = array();
			    $cursor["codigo"] = odbc_result($cur1,1);
			    $cursor["nombre"] = trim(utf8_encode(odbc_result($cur1,2)));
			    array_push($respuesta, $cursor);
				$i++;
			}
		}

	}
	echo json_encode($respuesta);
}
?>
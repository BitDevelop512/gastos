<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	if ($tipo == "0")
	{
		$query = "SELECT * FROM cx_ctr_fac WHERE estado='' ORDER BY codigo";
		$cur = odbc_exec($conexion, $query);
		$total = odbc_num_rows($cur);
		$respuesta = array();
		if ($total>0)
		{
			$i=0;
			while($i<$row=odbc_fetch_array($cur))
			{
				$cursor = array();
			    $cursor["codigo"] = odbc_result($cur,1);
			    $cursor["nombre"] = trim(utf8_encode(odbc_result($cur,2)));
			    array_push($respuesta, $cursor);
				$i++;
			}
		}
		else
		{
			$cursor = array();
		    $cursor["codigo"] = "0";
		    $cursor["nombre"] = "NO EXISTEN FACTORES";
			array_push($respuesta, $cursor);
		}
		echo json_encode($respuesta);
	}
	else
	{
		$factor = $_POST['factor'];
		$query = "SELECT estado FROM cx_ctr_fac WHERE codigo='$factor'";
		$cur = odbc_exec($conexion, $query);
		$estado = odbc_result($cur,1);
		$salida = new stdClass();
		$salida->estado = $estado;
		echo json_encode($salida);
	}
}
?>
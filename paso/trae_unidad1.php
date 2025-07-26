<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$consulta = $_POST['consulta'];
	$unidad = $_POST['centra'];
	$sigla = trim($_POST['sigla']);
	$pregunta = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad' AND unic='1'";
	$sql = odbc_exec($conexion, $pregunta);
	$unidad1 = odbc_result($sql,1);
	if ($consulta == "6")
	{
		$query = "SELECT subdependencia FROM cx_org_sub WHERE sigla='$sigla' AND unic='1' ORDER BY subdependencia";
	}
	else
	{
		if (($unidad == "2") or ($unidad == "3"))
		{
			$pregunta = "SELECT dependencia FROM cx_org_sub WHERE unidad='$unidad' AND sigla='$sigla'";
			$sql = odbc_exec($conexion, $pregunta);
			$dependencia = odbc_result($sql,1);
			$query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad' AND dependencia='$dependencia' ORDER BY subdependencia";
		}
		else
		{
			$query = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$unidad' ORDER BY subdependencia";
		}
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$unidades = "";
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$sigla = trim(utf8_encode(odbc_result($cur,1)));
		$unidades .= $sigla."|";
		$i++;
	}
 	// Se verifica si es unidad centralizadora especial
 	if (strpos($especial, $unidad1) !== false)
 	{
		$numero = "";
		$query = "SELECT unidad, dependencia FROM cx_org_sub WHERE especial='$unidad' ORDER BY unidad";
		$cur = odbc_exec($conexion, $query);
		while($i<$row=odbc_fetch_array($cur))
		{
			$n_unidad = odbc_result($cur,1);
			$n_dependencia = odbc_result($cur,2);
			$query1 = "SELECT subdependencia FROM cx_org_sub WHERE unidad='$n_unidad' ORDER BY dependencia, subdependencia";
			$cur1 = odbc_exec($conexion, $query1);
			while($j<$row=odbc_fetch_array($cur1))
			{
				$numero .= odbc_result($cur1,1)."|";
			}
		}
		$unidades .= $numero;
	}
	$salida->salida = $unidades;
	echo json_encode($salida);
}
?>
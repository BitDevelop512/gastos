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
		$query = "SELECT * FROM cx_ctr_pag WHERE tipo NOT IN ('R','X') ORDER BY codigo";
	}
	else
	{
		if ($tipo == "2")
		{
			$query = "SELECT * FROM cx_ctr_pag WHERE (tipo!='R' and tipo!='X') ORDER BY nombre";
		}
		else
		{
			$query = "SELECT * FROM cx_ctr_pag WHERE tipo='R' ORDER BY nombre";
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
	echo json_encode($respuesta);
}
// 24/09/2024 - Ajuste gastos desactivados
?>
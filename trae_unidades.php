<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
	$unidades = $_POST['unidades'];
	if ($sup_usuario == "1")
	{
		$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY subdepen";	
	}
	else
	{
		$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) WHERE subdepen IN ($unidades) ORDER BY subdepen";	
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = trim(odbc_result($cur,2));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
// 10/08/2023 - Ajuste tabla desde funcion para consultar cambio de siglas
// 16/05/2024 - Ajuste consulta desde super usuario
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
require('funciones.php');
if (is_ajax())
{
	if (!empty($_POST['tipo']))
	{
		$tipo = $_POST['tipo'];
	}
	else
	{
		$tipo = "0";
	}
	$v_unidades = "";
	if ($tipo == "6")
	{
		$pregunta = "SELECT subdependencia, sigla FROM cv_unidades WHERE unic='1' AND subdependencia!='301' ORDER BY sigla";
		$sql = odbc_exec($conexion, $pregunta);
		$i = 0;
		while ($i < $row = odbc_fetch_array($sql))
	 	{
	 		$v_unidades .= odbc_result($sql,1).",";
	 		$i++;
	 	}
	 	$v_unidades = substr($v_unidades,0,-1);
	 	$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) WHERE subdepen IN ($v_unidades) ORDER BY sigla";
	}
	else
	{
		if ($sup_usuario == "0")
		{
			$pregunta = "SELECT unidad, dependencia, unic FROM cv_unidades WHERE subdependencia='$uni_usuario'";
			$sql = odbc_exec($conexion, $pregunta);
			$v_unidad = odbc_result($sql,1);
			$v_dependencia= odbc_result($sql,2);
			$v_unic = odbc_result($sql,3);
			if ($v_unic == "1")
			{
				$pregunta1 = "SELECT subdependencia FROM cv_unidades WHERE unidad='$v_unidad' AND dependencia='$v_dependencia' ORDER BY subdependencia";
				$sql1 = odbc_exec($conexion, $pregunta1);
				$i = 0;
				while ($i < $row = odbc_fetch_array($sql1))
	 			{
	 				$v_unidades .= odbc_result($sql1,1).",";
	 				$i++;
	 			}
	 			$v_unidades = substr($v_unidades,0,-1);
	 			$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) WHERE subdepen IN ($v_unidades) ORDER BY sigla";
			}
			else
			{
				$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) WHERE subdepen='$uni_usuario' ORDER BY sigla";	
			}
		}
		else
		{
			$query = "SELECT subdepen, sigla FROM dbo.cf_sigla(1) ORDER BY sigla";
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
// 08/08/2023 - Ajuste consulta unidades con cambio de sigla
// 17/02/2025 - Ajuste consulta unidades por centralizadora
// 18/02/2025 - Ajuste nuevo reporte - Gestion Presupuesto
?>
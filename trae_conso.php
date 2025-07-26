<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$unidad = $_POST['unidad'];
	$sigla = $_POST['sigla'];
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	$pregunta = "SELECT conse FROM cx_pla_con WHERE unidad='$unidad' AND periodo='$periodo' AND ano='$ano'";
	$sql = odbc_exec($conexion,$pregunta);
	$total = odbc_num_rows($sql);
	if ($total>0)
	{
		$conse = odbc_result($sql,1);
		$salida->conse = $conse;
		$ruta = "fpdf/pdf/PlanInvCon_".$sigla."_".$periodo."_".$ano.".pdf";
		if (file_exists($ruta))
		{
			$archivo = "1";
		}
		else
		{
			$archivo = "0";
		}
		$salida->archivo = $archivo;
	}
	else
	{
		$salida->conse = "0";
		$salida->archivo = "0";
	}
	echo json_encode($salida);
}
// 11/09/2024 - Ajsute consulta consolidado por sigla en ruta
?>
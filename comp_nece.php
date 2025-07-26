<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$periodo = $_POST['periodo'];
	$ano = $_POST['ano'];
	if ($adm_usuario == "16")
	{
		// Notificacion Oficial de Planeacion
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba1!='0'";
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
	}
	if ($adm_usuario == "17")
	{
		// Notificacion Oficial de Planeacion
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba2!='0'";
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
	}
	if ($adm_usuario == "18")
	{
		// JEF_CEDE2
		$pregunta1 = "SELECT * FROM cx_pla_nes WHERE periodo='$periodo' AND ano='$ano' AND aprueba3!='0'";
		$cur5 = odbc_exec($conexion, $pregunta1);
		$total1 = odbc_num_rows($cur5);
	}
	$salida = new stdClass();
	$salida->salida = $total1;
	echo json_encode($salida);
}
?>
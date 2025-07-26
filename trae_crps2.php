<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$mes = date('m');
	$ano = date('Y');
	$ano1 = intval($ano)-1;
	$cuenta = $_POST['cuenta'];
	switch ($cuenta)
	{
		case '1':
			$recurso = "1";
			break;
		case '2':
		case '4':
			$recurso = "3";
			break;
		case '3':
			$recurso = "1,2,3";
			break;
		default:
			$recurso = "1";
			break;
	}
	if (($mes == "1") or ($mes == "2") or ($mes == "3"))
	{
		$query = "SELECT * FROM cx_crp WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cx_crp.conse1 AND (cx_cdp.vigencia='$ano1' OR cx_cdp.vigencia='$ano')) AND recurso IN ($recurso) AND saldo>0 ORDER BY CAST(numero as int)";
	}
	else
	{
		$query = "SELECT * FROM cx_crp WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cx_crp.conse1 AND cx_cdp.vigencia='$ano') AND recurso IN ($recurso) AND saldo>0 ORDER BY CAST(numero as int)";
	}
	$cur = odbc_exec($conexion, $query);
	$total = odbc_num_rows($cur);
	$respuesta = array();
	if ($total>0)
	{
		$i = 0;
		while($i<$row=odbc_fetch_array($cur))
		{
			$cursor = array();
		    $cursor["codigo"] = odbc_result($cur,1);
		    $cursor["nombre"] = odbc_result($cur,4);
			array_push($respuesta, $cursor);
			$i++;
		}
	}
	else
	{
		$cursor = array();
	    $cursor["codigo"] = "-";
	    $cursor["nombre"] = "- SIN SALDOS -";
		array_push($respuesta, $cursor);
	}
	echo json_encode($respuesta);
}
// 13/03/2024 - Ajuste cuenta DTN para cargue de CRP
?>
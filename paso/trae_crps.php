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
	if (($mes == "1") or ($mes == "2") or ($mes == "3"))
	{
		$query = "SELECT * FROM cx_crp WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cx_crp.conse1 AND (cx_cdp.vigencia='$ano1' OR cx_cdp.vigencia='$ano')) AND saldo>0 ORDER BY CAST(numero as int)";
	}
	else
	{
		$query = "SELECT * FROM cx_crp WHERE EXISTS(SELECT * FROM cx_cdp WHERE conse=cx_crp.conse1 AND cx_cdp.vigencia='$ano') AND saldo>0 ORDER BY CAST(numero as int)";
	}
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = odbc_result($cur,4);
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
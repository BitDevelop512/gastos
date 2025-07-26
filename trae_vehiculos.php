<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$query = "SELECT placa, clase, tipo FROM cx_pla_tra WHERE unidad='$uni_usuario' ORDER BY placa";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor = array();
	    $cursor["placa"] = odbc_result($cur,1);
	    $cursor["clase"] = odbc_result($cur,2);
	    $cursor["tipo"] = odbc_result($cur,3);
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
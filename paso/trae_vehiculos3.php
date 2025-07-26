<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$pregunta = "SELECT sigla FROM cx_org_cmp WHERE conse='$tip_usuario'";
	$sql = odbc_exec($conexion, $pregunta);
	$compa = trim(odbc_result($sql,1));
	$valida = strpos($usu_usuario, "_");
	$valida = intval($valida);
	if ($valida == "0")
	{
		$complemento = "1=1";
	}
	else
	{
		$v1 = explode("_", $usu_usuario);
		$v2 = $v1[1];
    	$v3 = explode("_", $log_usuario);
    	$v4 = $v3[1];
		$complemento = "(compania='$v2' OR compania='$v4' OR compania='$compa')";
	}
	$clase = $_POST['clase'];
	$query = "SELECT placa, clase, tipo FROM cx_pla_tra WHERE unidad='$uni_usuario' AND clase='$clase' AND empadrona IN ('1','4') AND $complemento AND estado='1' ORDER BY placa";
	$cur = odbc_exec($conexion, $query);
	$respuesta = array();
	$i = 0;
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
// 18/10/2023 - Ajuste de consulta de vehiculos solo activos
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$division = $_POST['division'];
	$brigada = $_POST['brigada'];
	$unidad = $_POST['unidad'];
	$respuesta = array();
	if (($division == "1") OR ($division == "2") OR ($division == "3"))
	{
    	$query1 = "SELECT subdependencia, sigla FROM cx_org_sub WHERE dependencia='$brigada' ORDER BY subdependencia";
      	$cur1 = odbc_exec($conexion, $query1);
		$total = odbc_num_rows($cur1);
		$i = 0;
      	while($i<$row=odbc_fetch_array($cur1))
      	{
			$cursor = array();
		    $cursor["unidad"] = odbc_result($cur1,1);
		    $cursor["sigla"] = trim(utf8_encode(odbc_result($cur1,2)));
		    array_push($respuesta, $cursor);
			$i++;
      	}
	}
	else
	{
    	$query1 = "SELECT subdependencia, sigla FROM cx_org_sub WHERE unidad='$division' ORDER BY subdependencia";
      	$cur1 = odbc_exec($conexion, $query1);
		$total = odbc_num_rows($cur1);
		$i = 0;
      	while($i<$row=odbc_fetch_array($cur1))
      	{
			$cursor = array();
		    $cursor["unidad"] = odbc_result($cur1,1);
		    $cursor["sigla"] = trim(utf8_encode(odbc_result($cur1,2)));
		    array_push($respuesta, $cursor);
			$i++;
      	}
	}

	echo json_encode($respuesta);
}
?>
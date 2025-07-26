<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$departamento = $_POST['departamento'];
	$query = "SELECT * FROM cx_ctr_ciu WHERE conse='$departamento' ORDER BY codigo";
	$cur = odbc_exec($conexion, $query);
	$respuesta=array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor=array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = utf8_encode(odbc_result($cur,3));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
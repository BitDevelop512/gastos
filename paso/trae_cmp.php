<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$tipo = $_POST['tipo'];
	switch ($tipo)
	{
		case '1':
		case '2':
		case '3':
			$tipo1 = "1";
			break;		
		default:
			$tipo1 = "2";
			break;
	}
	$query = "SELECT * FROM cx_org_cmp WHERE tipo='$tipo1' ORDER BY conse";	
	$cur = odbc_exec($conexion, $query);
	$respuesta=array();
	$i=0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$cursor=array();
	    $cursor["codigo"] = odbc_result($cur,1);
	    $cursor["nombre"] = trim(utf8_encode(odbc_result($cur,3)));
	    array_push($respuesta, $cursor);
		$i++;
	}
	echo json_encode($respuesta);
}
?>
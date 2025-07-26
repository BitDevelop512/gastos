<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
require('permisos.php');
if (is_ajax())
{
	$directiva = $_POST['directiva'];
	$tipo = $_POST['tipo'];
	if ($directiva != "4")
	{
		$tipo = 1;
	}
	$query = "SELECT * FROM cx_ctr_niv WHERE directiva='$directiva' AND tipo='$tipo' ORDER BY nivel";
	$cur = odbc_exec($conexion, $query);
	$datos = "";
	$i = 0;
	while($i<$row=odbc_fetch_array($cur))
	{
		$nivel = odbc_result($cur,1);
		$valor1 = odbc_result($cur,2);
		$valor2 = odbc_result($cur,3);
		$datos .= $nivel."|".$valor1."|".$valor2."|#";
		$i++;
	}
	$salida = new stdClass();
	$salida->datos = $datos;
	echo json_encode($salida);
}
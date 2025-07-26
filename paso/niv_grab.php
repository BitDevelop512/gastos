<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$directiva = $_POST['directiva'];
	$niveles = $_POST['niveles'];
	$tipo = $_POST['tipo'];
	if ($directiva != "4")
	{
		$tipo = 1;
	}
	$datos = $_POST['datos'];
	// Se borran los niveles de la directiva
	$borra = "DELETE FROM cx_ctr_niv WHERE directiva='$directiva' AND tipo='$tipo'";
	if (!odbc_exec($conexion, $borra))
	{
		$confirma = "0";
	}
	else
	{
		$confirma = "1";
	}
	// Se parte campo datos
	$num_datos = explode("#",$datos);
	for ($i=0;$i<count($num_datos)-1;++$i)
	{
		$paso = $num_datos[$i];
		$num_datos1 = explode("|",$paso);
		$v1 = $num_datos1[0];
		$v2 = $num_datos1[1];
		$v3 = $num_datos1[2];
		$graba = "INSERT INTO cx_ctr_niv (nivel, valor1, valor2, directiva, tipo) VALUES ('$v1', '$v2', '$v3', '$directiva', '$tipo')";
		$sql1 = odbc_exec($conexion, $graba);
	}
	$salida = new stdClass();
	$salida->salida = $confirma;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conses = $_POST['conses'];
	$conses = substr($conses, 0, -1);
	$num_conses = explode(",",$conses);
	$consecus = "";
	for ($i=0;$i<count($num_conses);++$i)
	{
	  $paso = $num_conses[$i];
	  $paso = substr($paso, 3);
	  $paso = substr($paso, 0, -2);
	  $paso = "'".$paso."',";
	  $consecus .= $paso;
	}
	$consecus = substr($consecus, 0, -1);
	$rol = $_POST['rol'];
	$pregunta = "SELECT permisos FROM cx_ctr_rol WHERE conse='$rol'";
	$cur = odbc_exec($conexion, $pregunta);
	$permisos = odbc_result($cur,1);
	$query = "UPDATE cx_usu_web SET permisos='$permisos' WHERE conse IN ($consecus)";
	$sql = odbc_exec($conexion, $query);
	$salida = new stdClass();
	$salida->salida = "1";
	echo json_encode($salida);
}
?>
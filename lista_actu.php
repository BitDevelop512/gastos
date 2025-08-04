<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$documentacion = trim($_POST['documentacion']);
	$documentacion = iconv("UTF-8", "ISO-8859-1", $documentacion);
	$orden = $_POST['orden'];
	$es_recompensa = $_POST['es_recompensa'];
	$es_informacion = $_POST['es_informacion'];
	$directiva = $_POST['directiva'];
	
	$query = "UPDATE lista_0012 SET orden='$orden', documentacion='$documentacion', es_recompensa='$es_recompensa', es_informacion='$es_informacion', directiva='$directiva'  WHERE conse='$conse'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT conse FROM lista_0012 WHERE conse='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$conse = $_POST['conse'];
	$clase = $_POST['clase'];
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$tipo = $_POST['tipo'];
	$query = "UPDATE cx_ctr_bie SET clase='$clase', nombre='$nombre', tipo='$tipo' WHERE codigo='$conse'";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT codigo FROM cx_ctr_bie WHERE codigo='$conse'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
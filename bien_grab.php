<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
$ano = date('Y');
if (is_ajax())
{
	$clase = $_POST['clase'];
	$nombre = trim($_POST['nombre']);
	$nombre = iconv("UTF-8", "ISO-8859-1", $nombre);
	$tipo = $_POST['tipo'];
	$cur1 = odbc_exec($conexion,"SELECT isnull(max(codigo),0)+1 AS conse FROM cx_ctr_bie");
	$consecu = odbc_result($cur1,1);
	$query = "INSERT INTO cx_ctr_bie (codigo, clase, nombre, tipo) VALUES ('$consecu', '$clase', '$nombre', '$tipo')";
	$sql = odbc_exec($conexion, $query);
	$query1 = "SELECT codigo FROM cx_ctr_bie WHERE codigo='$consecu'";
	$cur = odbc_exec($conexion, $query1);
	$conse1 = odbc_result($cur,1);
	$salida = new stdClass();
	$salida->salida = $conse1;
	echo json_encode($salida);
}
?>
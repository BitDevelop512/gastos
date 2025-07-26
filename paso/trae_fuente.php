<?php
session_start();
error_reporting(0);
require('conf.php');
require('permisos.php');
$cedula = $_POST['cedula'];
$pregunta = "SELECT nombre FROM cx_pla_inf WHERE cedula='$cedula' AND unidad='$uni_usuario'";
$sql = odbc_exec($conexion,$pregunta);
$total = odbc_num_rows($sql);
if ($total>0)
{
	$salida->nombre = trim(utf8_encode(odbc_result($sql,1)));
}
else
{
	$salida->nombre = "";
}
echo json_encode($salida);
?>
<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
if (is_ajax())
{
	$query = "SELECT inactividad FROM cx_ctr_par";
    $sql = odbc_exec($conexion,$query);
    $inactividad = odbc_result($sql,1);
    $salida->salida = $inactividad;
	echo json_encode($salida);
}
?>
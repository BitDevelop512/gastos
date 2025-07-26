<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $cedula = $_POST['cedula'];
    $query = "SELECT TOP 1 nombre FROM cx_gas_dis WHERE cedula='$cedula'";
    $sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    if ($total > 0)
    {
    	$nombre = odbc_result($sql,1);
		$nombre = utf8_encode($nombre);
    }
    else
    {
    	$nombre = "";
    }
    $salida->nombre = $nombre;
    $salida->total = $total;
    echo json_encode($salida);
}
?>
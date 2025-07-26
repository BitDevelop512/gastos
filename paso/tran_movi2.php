<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $fecha1 = $_POST['fecha1'];
    $fecha2 = $_POST['fecha2'];
    $tipo = $_POST['tipo'];
    $solicitudes = $_POST['solicitudes'];
    $pregunta = "SELECT ISNULL(SUM(total),0) AS total FROM cx_tra_mov WHERE usuario='$usu_usuario' AND unidad='$uni_usuario' AND convert(datetime,fecha,102) BETWEEN convert(datetime,'$fecha1',102) AND (convert(datetime,'$fecha2',102)+1) AND solicitud IN ($solicitudes) AND tipo='$tipo'";
    $sql = odbc_exec($conexion,$pregunta);
    $total = odbc_num_rows($sql);
    $suma = odbc_result($sql,1);
    if ($suma == ".00")
    {
        $suma = "0.00";
    }
    $salida = new stdClass();
   	$salida->salida = $suma;
   	$salida->total = $total;
    echo json_encode($salida);
}
?>
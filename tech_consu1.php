<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $pregunta = "SELECT conse, unidad, dependencia, tipo, datos FROM cx_tra_ted WHERE conse='$conse'";
    $sql = odbc_exec($conexion,$pregunta);
    $conse = odbc_result($sql,1);
    $unidad = odbc_result($sql,2);
    $dependencia = odbc_result($sql,3);
    $tipo = trim(odbc_result($sql,4));
    $datos = trim(utf8_encode(odbc_result($sql,5)));
    $salida = new stdClass();
    $salida->conse = $conse;
    $salida->unidad = $unidad;
    $salida->dependencia = $dependencia;
    $salida->tipo = $tipo;
    $salida->datos = $datos;
    echo json_encode($salida);
}
?>
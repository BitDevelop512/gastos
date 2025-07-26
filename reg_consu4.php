<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $conse = $_POST['conse'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT lista FROM cx_reg_rec WHERE conse='$conse' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $lista = trim(odbc_result($sql,1));
    $salida = new stdClass();
    $salida->lista = $lista;
    echo json_encode($salida);
}
?>
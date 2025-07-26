<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $valor = $_POST['valor'];
    $tipo = $_POST['tipo'];
    $ano = $_POST['ano'];
    $pregunta = "SELECT responsable, comandante, elaboro, reviso FROM cx_rel_gas WHERE conse='$valor' AND tipo='$tipo' AND ano='$ano'";
    $sql = odbc_exec($conexion,$pregunta);
    $salida = new stdClass();
    $responsable = trim(utf8_encode(odbc_result($sql,1)));
    $comandante = trim(utf8_encode(odbc_result($sql,2)));
    $elaboro = trim(utf8_encode(odbc_result($sql,3)));
    $reviso = trim(utf8_encode(odbc_result($sql,4)));
    $salida->responsable = $responsable;
    $salida->comandante = $comandante;
    $salida->elaboro = $elaboro;
    $salida->reviso = $reviso;
    echo json_encode($salida);
}
?>
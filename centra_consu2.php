<?php
session_start();
error_reporting(0);
require('conf.php');
require('funciones.php');
include('permisos.php');
if (is_ajax())
{
    $periodo = $_POST['periodo'];
    $ano = $_POST['ano'];
	$query = "SELECT * FROM cx_pla_cen WHERE unidad='$uni_usuario' AND periodo='$periodo' AND ano='$ano' AND estado=''";
	$sql = odbc_exec($conexion, $query);
    $total = odbc_num_rows($sql);
    $gastos = trim(odbc_result($sql,9));
    $pagos = trim(odbc_result($sql,10));
    $recompensas = trim(odbc_result($sql,11));
    $gastos1 = trim(utf8_encode(odbc_result($sql,12)));
    $pagos1 = trim(utf8_encode(odbc_result($sql,13)));
    $recompensas1 = trim(utf8_encode(odbc_result($sql,14)));
    $salida->salida = $total;
    $salida->gastos = $gastos;
    $salida->pagos = $pagos;
    $salida->recompensas = $recompensas;
    $salida->gastos1 = $gastos1;
    $salida->pagos1 = $pagos1;
    $salida->recompensas1 = $recompensas1;
    echo json_encode($salida);
}
?>